const { exec } = require('child_process');

const command = '"C:\\Program Files\\NAPS2\\NAPS2.exe"';

exec(command, (error, stdout, stderr) => {
  if (error) {
    console.error(`❌ Exec error: ${error.message}`);
    return;
  }
  if (stderr) {
    console.error(`⚠️ Exec stderr: ${stderr}`);
    return;
  }
  console.log(`✅ Exec stdout: ${stdout}`);
});
