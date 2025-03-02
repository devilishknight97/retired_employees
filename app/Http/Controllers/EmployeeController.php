<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // GET /api/employees
    public function getEmployees()
    {
        \Log::info("Employees API Hit");

        $employees = Employee::get();

        return $employees;
    }

    // GET /api/employees/{employee_number} (Get single employee)
    public function getEmployee($employee_number)
    {
        $employee = Employee::where('employee_number', $employee_number)->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

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
}
