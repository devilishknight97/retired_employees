// const express = require('express');
// const cors = require('cors');
// const bodyParser = require('body-parser');
// const { scanDocument } = require('./scanner');

// const app = express();
// app.use(cors());
// app.use(bodyParser.json());

// app.post('/scan/:employeeNumber', async (req, res) => {
//   const employeeNumber = req.params.employeeNumber;
//   console.log(`📨 Received scan request for employee ${employeeNumber}`);

//   try {
//     const result = await scanDocument(employeeNumber);
//     console.log('✅ Scan complete:', result);
//     res.json(result);
//   } catch (error) {
//     console.error('❌ Scan error:', error);
//     res.status(500).json({ error: error.message || 'Scan failed' });
//   }
// });


// app.listen(3001, () => {
//     console.log('Scan server listening on port 3001');
// });
