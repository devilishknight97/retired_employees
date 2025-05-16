// const { exec } = require('child_process');
// const path = require('path');
// const fs = require('fs');
// const axios = require('axios');
// const FormData = require('form-data');


// async function scanDocument(employeeNumber) {
//     return new Promise((resolve, reject) => {
//         const outputDir = path.join(__dirname, 'scans');
//         if (!fs.existsSync(outputDir)) {
//             fs.mkdirSync(outputDir);
//         }

//         const outputPath = path.join(outputDir, `${employeeNumber}.pdf`);
//         const command = `naps2.console.exe -o "${outputPath}" -f pdf`;

//         exec(command, async (error, stdout, stderr) => {
//             if (error) {
//                 console.error('Scan failed:', stderr);
//                 return reject(new Error(stderr));
//             }

//             console.log('Scan successful:', stdout);

//             try {
//                 const formData = new FormData();
//                 formData.append('file', fs.createReadStream(outputPath));
//                 formData.append('employee_number', employeeNumber);

//                 const response = await axios.post(
//                     `http://127.0.0.1:8000/employees/${employeeNumber}/upload`,
//                     formData,
//                     {
//                         headers: formData.getHeaders(),
//                         withCredentials: true,
//                     }
//                 );

//                 resolve(response);
//             } catch (uploadError) {
//                 console.error('Upload failed:', uploadError.message);
//                 reject(uploadError);
//             }
//         });
//     });
// }

// module.exports = { scanDocument };
