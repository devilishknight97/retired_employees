<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class EmployeeController extends Controller
{
    // GET /api/employees
    public function getEmployees()
    {
        Log::info("Employees API Hit");

        $employees = Employee::get();

        $employees->transform(function($emp) {
            $emp->picture_url = $emp->picture
                ? Storage::url($emp->picture)
                : asset('default-avatar.png');
                
            return $emp;
        });

        \Log::info(json_encode($employees));
        
        return $employees;
    }

    // GET /api/employees/{employee_number} (Get single employee)
    public function getEmployee($employee_number)
    {
        
        // Retrieve the employee record
        $employee = Employee::where('employee_number', $employee_number)->firstOrFail();
    
        // Define the path to the employee's document folder
        $documentPath = public_path("storage/employee_documents/{$employee_number}");
    
        // Initialize documents array
        $documents = [];
    
        // Check if the directory exists and read its contents
        if (file_exists($documentPath)) {
            // Get all files, filtering out '.' and '..'
            $files = array_diff(scandir($documentPath), ['.', '..']);
            $documents = array_values($files); // Re-index the array
        }
    
        // Add the documents array to the employee data
        $employee->documents = $documents;

        $employee->picture_url = $employee->picture
        ? Storage::url($employee->picture)
        : asset('default-avatar.png');
    
        return response()->json($employee);
    }
    

    // POST /api/employees
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_number' => 'required|integer|unique:employees',
            'full_name'       => 'required|string|max:100',
            'workplace'       => 'nullable|string|max:100',
            'start_work_date' => 'required|date',
            'birthdate'       => 'required|date',
            'daily_wage_appointment_date' => 'nullable|date',
            'contract_appointment_date'   => 'nullable|date',
            'official_appointment_date'   => 'nullable|date',
            'grade_at_appointment'        => 'required|string|max:100',
            'grade_at_retirement'         => 'required|string|max:100',
            'grade_received_date'         => 'nullable|date',
            'port_transfer_date'          => 'nullable|date',
            'previous_department'         => 'nullable|string|max:100',
            'service_termination_date'    => 'nullable|date',
            'termination_reason'          => 'nullable|string|in:بلوغ السنة القانونية,تقاعد إختياري,بسبب الوفاة,فصل من العمل,العجز الطبي',

        ]);

        $employee = Employee::create($data);
        return response()->json($employee, 201);
    }

    // PUT /api/employees/{employee_number}
    public function update(Request $request, $employee_number)
    {
        $employee = Employee::where('employee_number', $employee_number)->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $data = $request->validate([
            'full_name'       => 'required|string|max:100',
            'workplace'       => 'nullable|string|max:100',
            'start_work_date' => 'required|date',
            'birthdate'       => 'required|date',
            'daily_wage_appointment_date' => 'nullable|date',
            'contract_appointment_date'   => 'nullable|date',
            'official_appointment_date'   => 'nullable|date',
            'grade_at_appointment'        => 'required|string|max:100',
            'grade_at_retirement'         => 'nullable|string|max:50',
            'grade_received_date'         => 'nullable|date',
            'port_transfer_date'          => 'nullable|date',
            'previous_department'         => 'nullable|string|max:100',
            'service_termination_date'    => 'nullable|date',
            'termination_reason'          => 'nullable|string|in:بلوغ السنة القانونية,تقاعد إختياري,بسبب الوفاة,فصل من العمل,العجز الطبي',
        ]);

        $employee->update($data);
        return response()->json($employee);
    }

    // DELETE /api/employees/{employee_number}
    public function destroy($employee_number)
    {
        $employee = Employee::where('employee_number', $employee_number)->firstOrFail();

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
    
        $employees = $query === ''
            ? Employee::all()
            : Employee::where('employee_number', 'like', "%{$query}%")
                ->orWhere('full_name', 'like', "%{$query}%")
                ->get();
    
        // Add the picture URL
        $employees->transform(function ($emp) {
            $emp->picture_url = $emp->picture
                ? Storage::url($emp->picture)
                : asset('default-avatar.png');
            return $emp;
        });
    
        return response()->json($employees);
    }


    public function uploadFile(Request $request, $employee_number)
    {

        \Log::info($request->hasFile('file') ? 'file true' : 'file false');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
    
            $path = storage_path("app/public/employee_documents/{$employee_number}/");
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
    
            $file->move($path, $filename);
    
            return response()->json(['message' => 'File uploaded successfully.']);
        }
    
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
    



public function show($employee_number)
{
    $employee = Employee::where('employee_number', $employee_number)->firstOrFail();

    $documentPath = public_path("storage/employee_documents/{$employee_number}");
    $documents = [];

    if (file_exists($documentPath)) {
        $documents = array_values(array_diff(scandir($documentPath), ['.', '..']));
    }

    $employee->documents = $documents;

    return response()->json($employee);
}
public function scanDocument(Request $request)
{
    $employee_number = $request->input('employee_number');
    $locator = $request->input('locator'); // e.g. "contracts"
    $filename = $request->input('filename'); // e.g. "contract_may2025.pdf"

    if (!$employee_number || !$filename) {
        return response()->json(['error' => 'Missing required fields'], 400);
    }

    // Sanitize locator (optional fallback)
    $locator = $locator ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $locator) : 'uncategorized';

    // Build full path
    $folder = storage_path("app/public/employee_documents/{$employee_number}/{$locator}");
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // Make sure .pdf extension is there
    if (!Str::endsWith($filename, '.pdf')) {
        $filename .= '.pdf';
    }

    $fullPath = "$folder/$filename";

    // Launch scanner (e.g. via NAPS2 or whatever method you're using)
    $batPath = storage_path('app/launch_naps2.bat');
    $naps2Exe = '"C:\\Program Files\\NAPS2\\naps2.console.exe"';

    // Example NAPS2 CLI usage
    file_put_contents($batPath, "$naps2Exe -o \"$fullPath\" -f pdf\n");
    shell_exec("start \"\" \"$batPath\"");

    return response()->json([
        'success' => true,
        'message' => "Scanning to $fullPath",
        'file_url' => asset("storage/employee_documents/{$employee_number}/{$locator}/$filename")
    ]);
}



// public function scanDocument($employee_number)
// {
//     try {
//         // Define the path in storage (e.g. storage/app/public/employee_documents/34310)
//         $folder = "employee_documents/{$employee_number}";
//         $storagePath = storage_path("app/public/$folder");

//         // Ensure directory exists
//         if (!file_exists($storagePath)) {
//             mkdir($storagePath, 0777, true);
//         }

//         // Define the scan output file (we'll name it something unique like scan_20250422_1010.pdf)
//         $filename = 'scan_' . now()->format('Ymd_His') . '.pdf';
//         $fullPath = "$storagePath/$filename";

//         // NAPS2 CLI: command to scan and save directly
//         $batPath = storage_path('app/launch_naps2.bat');
//         $cmd = "\"C:\\Program Files\\NAPS2\\naps2.console.exe\" -o \"$fullPath\" -f pdf";

//         file_put_contents($batPath, $cmd);
//         shell_exec("start \"\" \"$batPath\"");

//         return response()->json([
//             'success' => true,
//             'message' => "Scanning to $fullPath",
//             'file' => "$folder/$filename"
//         ]);

//     } catch (\Throwable $e) {
//         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
//     }
// }
// public function scanDocument($employee_number)
// {
//     $employee = Employee::where('employee_number', $employee_number)->first();

//     if (!$employee) {
//         return response()->json(['success' => false, 'error' => 'Employee not found'], 404);
//     }

//     $folder = storage_path("app/public/employee_documents/{$employee_number}");

//     if (!file_exists($folder)) {
//         mkdir($folder, 0777, true); // Create the folder if it doesn't exist
//     }

//     // Generate a unique filename
//     $filename = 'scan_' . Str::random(8) . '.pdf';
//     $filePath = "$folder/$filename";

//     // Create a temporary batch file to launch NAPS2 and save to correct folder
//     $batPath = storage_path('app/launch_naps2.bat');
//     $naps2Exe = '"C:\Program Files\NAPS2\NAPS2.exe"';

//     // Make sure the output folder exists in NAPS2 profile
//     file_put_contents($batPath, "$naps2Exe -o \"$filePath\" -f pdf\n");

//     // Execute the .bat file
//     shell_exec("start \"\" \"$batPath\"");

//     return response()->json([
//         'success' => true,
//         'file' => "employee_documents/{$employee_number}/$filename"
//     ]);
// }


public function uploadPicture(Request $request, $employee_number)
{
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $filename = $employee_number . '.' . $file->getClientOriginalExtension();

        // Save to employee-specific folder
        $relativePath = "employee_pictures/{$employee_number}/{$filename}";
        $folderPath = storage_path("app/public/employee_pictures/{$employee_number}");

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $file->move($folderPath, $filename);

        // Save the relative path in the database
        $employee = Employee::where('employee_number', $employee_number)->first();
        $employee->picture = $relativePath;
        $employee->save();

        return response()->json([
            'picture_url' => asset("storage/{$relativePath}")
        ]);
    }

    return response()->json(['error' => 'No picture uploaded.'], 400);
}


public function deleteDocument($employee_number, $filename)
{
    $path = "employee_documents/$employee_number/$filename";

    if (!Storage::disk('public')->exists($path)) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    Storage::disk('public')->delete($path);

    return response()->json(['message' => 'File deleted successfully.']);
}

}
