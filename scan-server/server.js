const folderPath = `C:\\path\\to\\public\\storage\\employee_documents\\${employeeNumber}`;

// make sure it exists
if (!fs.existsSync(folderPath)) {
  fs.mkdirSync(folderPath, { recursive: true });
}

// NAPS2 command
const command = `"C:\\Program Files\\NAPS2\\NAPS2.Console.exe" scan --output "${folderPath}\\scan_${Date.now()}.pdf"`;
