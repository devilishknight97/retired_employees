<template>
  <div class="container mx-auto max-h-32 p-4 text-right" dir="rtl">
    <!-- Header with Back Button -->
    <div class="flex justify-start items-center mb-4">
      <button @click="goBack" class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-600">
        الصفحة السابقة
      </button>
    </div>

    <h1 class="text-3xl font-bold text-center mb-6">تفاصيل الموظف</h1>

    <div v-if="employee" class="flex flex-col md:flex-row gap-6">
      <!-- Documents Section -->
      <div class="md:w-1/3">
        <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
          <h2 class="text-xl font-semibold mb-3">المستندات</h2>

          <!-- Search Bar -->
          <div class="mb-3 flex gap-1">
            <input
              v-model="fileSearchQuery"
              placeholder="ابحث باسم الملف"
              class="flex-1 px-3 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <button @click="clearFileSearch" class="bg-gray-500 text-white px-2 py-1 rounded hover:bg-gray-700">
              مسح
            </button>
          </div>

          <!-- Documents List -->
          <div v-if="filteredDocuments.length" class="space-y-2">
            <div
              v-for="doc in filteredDocuments"
              :key="doc"
              class="flex justify-between items-center border p-2 rounded bg-white hover:bg-gray-50"
            >
            <a :href="documentUrl(doc)" target="_blank" class="text-blue-600 hover:underline truncate">
  {{ fileNameMap[doc] || doc }}
</a>
              <div class="flex gap-1">
                <button @click="downloadDocument(doc)" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">⬇️</button>
                <button @click="deleteDocument(doc)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">🗑️</button>
              </div>
            </div>
          </div>
          <div v-else class="text-center text-gray-600 py-2">لا يوجد مستندات</div>
        </div>
      </div>

      <!-- Employee Info & Actions -->
      <div class="md:w-2/3">
        <div class="bg-white p-4 rounded-lg shadow-md mb-6 flex items-center justify-between">
          <div class="flex-1">
            <h2 class="text-xl font-bold mb-4">المعلومات الأساسية</h2>
            <div class="grid grid-cols-2 gap-4 text-base">
              <div><span class="font-bold">الاسم:</span> {{ employee.full_name }}</div>
              <div><span class="font-bold">الرقم:</span> {{ employee.employee_number }}</div>
              <div><span class="font-bold">القسم:</span> {{ employee.workplace }}</div>
              <div><span class="font-bold">المباشرة:</span> {{ employee.start_work_date }}</div>
              <div><span class="font-bold">الميلاد:</span> {{ employee.birthdate }}</div>
              <div> <span class="font-bold">تاريخ التعيين بالأجر اليومي:</span> {{ employee.daily_wage_appointment_date || 'لا يوجد' }}</div>
              <div> <span class="font-bold">تاريخ التعيين بموجب عقد :</span> {{ employee.contract_appointment_date || 'لا يوجد' }}</div>
               <div> <span class="font-bold">تاريخ التصنيف أو التعيين  :</span> {{ employee.official_appointment_date || 'لا يوجد' }}</div>
              <div> <span class="font-bold"> الدرجة عند التعيين  :</span> {{ employee.grade_at_appointment || 'لا يوجد' }}</div>
               <div> <span class="font-bold">الدرجة عند التقاعد :</span> {{ employee.grade_at_retirement }}</div>
              <div> <span class="font-bold">تاريخ الحصول على الدرجة  </span> {{ employee.grade_received_date}}</div>
              <div> <span class="font-bold">تاريخ النقل الى الميناء  :</span> {{ employee.port_transfer_date || 'لا يوجد'}}</div>
              <div> <span class="font-bold">الجهة المنتقل منها </span> {{ employee.previous_department || 'لا يوجد'}}</div>
               <div> <span class="font-bold">تاريخ إنهاء الخدمة  :</span> {{ employee.service_termination_date}}</div>
              <div> <span class="font-bold">سبب إنهاء الخدمة:</span> {{ employee.termination_reason}}</div>
            </div>
          </div>
          <div class="flex flex-col items-center ml-4">
            <img :src="employee.picture_url" alt="Avatar" class="w-20 h-20 rounded-full object-cover" />
            <button @click="$refs.picInput.click()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded text-sm">تغيير الصورة</button>
            <input type="file" ref="picInput" class="hidden" @change="uploadPicture" />
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 justify-center">
          <router-link :to="`/app/edit/${employee.employee_number}`" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 text-lg">تعديل</router-link>
          <button @click="deleteEmployee(employee.employee_number)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 text-lg">حذف</button>
          <button @click="openFileInput(employee.employee_number)" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 text-lg">رفع ملف</button>
        </div>

        <!-- Scan File Input -->
    <div class="mt-4 p-4 border rounded bg-yellow-50 max-w-md mx-auto">
      <label class="block mb-2 font-semibold text-gray-700">اسم المستند قبل المسح</label>
      <input
        v-model="proposedFileName"
        placeholder="اسم الملف بدون .pdf"
        class="w-full px-3 py-2 border rounded mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
      />
      <button
        :disabled="!proposedFileName || isScanning"
        @click="scanDocument"
        class="w-full bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {{ isScanning ? 'جار المسح...' : 'مسح مستند' }}
      </button>
    </div>

    <!-- Hidden File Input -->
    <input type="file" ref="fileInput" class="hidden" @change="uploadFile" />
  </div>
    </div>
    </div>
</template>

<script>
import axios from '@/axios.js';

export default {
  name: 'EmployeeDetail',
  data() {
  return {
    employee: null,
    fileSearchQuery: '',
    allFiles: [],
    fileNameMap: {}, // Map: sanitizedName.pdf => ArabicName
    uploadEmployee: null,
    isScanning: false,
    scannedPdfBlob: null,
    proposedFileName: '',
  };
  },
  mounted() {
    this.fetchEmployee();

    // Load scanner.js from local public folder
    const script = document.createElement('script');
    script.src = '/js/scanner.js'; // ✅ Local copy
    script.onload = () => {
      console.log('✅ Local scanner.js loaded successfully');
    };
    script.onerror = () => {
      console.error('❌ Failed to load local scanner.js');
      this.scanSuccessMessage = 'فشل تحميل مكتبة المسح من الخادم المحلي.';
    };
    document.head.appendChild(script);
  },
  computed: {
    filteredDocuments() {
      const q = this.fileSearchQuery.trim().toLowerCase();
      return q ? this.allFiles.filter(doc => doc.toLowerCase().includes(q)) : this.allFiles;
    }
  },
  methods: {
    goBack() {
      this.$router.back();
    },
    async fetchEmployee() {
      try {
        const emp = this.$route.params.employee_number;
        const res = await axios.get(`/employees/${emp}`);
        this.employee = res.data;
        this.allFiles = Array.isArray(res.data.documents) ? res.data.documents : [];
        const raw = localStorage.getItem(`fileNameMap_${this.employee.employee_number}`);
        this.fileNameMap = raw ? JSON.parse(raw) : {};
      } catch (err) {
        console.error('Error fetching employee:', err);
      }
    },
    documentUrl(doc) {
      return `/storage/employee_documents/${this.employee.employee_number}/${doc}`;
    },
    downloadDocument(doc) {
      const link = document.createElement('a');
      link.href = this.documentUrl(doc);
      link.download = doc;
      link.click();
    },
    async deleteDocument(doc) {
      if (!confirm(`هل أنت متأكد من حذف المستند "${doc}"؟`)) return;
      try {
        await axios.delete(`/employees/${this.employee.employee_number}/employee_documents/${doc}`);
        this.allFiles = this.allFiles.filter(f => f !== doc);
      } catch (err) {
        console.error('Error deleting document:', err);
      }
    },
    async deleteEmployee(emp) {
      if (!confirm('هل أنت متأكد من حذف الموظف؟')) return;
      try {
        await axios.delete(`/employees/${emp}`);
        this.$router.push('/app/employees');
      } catch (err) {
        console.error('Error deleting employee:', err);
      }
    },
    openFileInput(emp) {
      this.uploadEmployee = emp;
      this.$refs.fileInput.click();
    },
    async uploadFile(e) {
      const file = e.target.files[0];
      console.log(this.uploadEmployee)

      if (!file || !this.uploadEmployee) return;
      const form = new FormData();
      form.append('file', file);
      try {
        await axios.post(`/employees/${this.employee.employee_number}/upload`, form, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
        alert('تم رفع الملف بنجاح');
        this.fetchEmployee();
      } catch (err) {
        console.error('Upload error:', err.response?.data);
        alert('فشل رفع الملف');
      }
    },
    async uploadPicture(e) {
      const file = e.target.files[0];
      if (!file) return;
      const form = new FormData();
      form.append('picture', file);
      try {
        const { data } = await axios.post(
          `/employees/${this.employee.employee_number}/picture`,
          form,
          { headers: { 'Content-Type': 'multipart/form-data' } }
        );
        this.employee.picture_url = data.picture_url;
        alert('تم تغيير الصورة بنجاح');
      } catch (err) {
        console.error(err);
        alert('فشل رفع الصورة');
      }
    },
    async scanDocument() {
  if (this.isScanning) return;
  if (!window.scanner) {
    alert('مكتبة المسح غير محملة.');
    return;
  }

  if (!this.proposedFileName) {
    alert('يرجى إدخال اسم المستند قبل المسح.');
    return;
  }

  const sanitizeFilename = (name) => {
    return name
      .normalize('NFKD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^\w\- ]+/g, '')
      .replace(/\s+/g, '_');
  };

  const sanitizedName = sanitizeFilename(this.proposedFileName);

  //'@/../../storage/app'
  // const fullSavePath = `E:\\Julyana\\Retired Employees\\RetiredEmployees\\storage\\app\\public\\employee_documents\\${this.employee.employee_number}\\${sanitizedName}.pdf`;
  const fullSavePath = `C:Users\\pc\\Herd\\RetiredEmployees\\storage\\app\\public\\employee_documents\\${this.employee.employee_number}\\${sanitizedName}.pdf`;

  this.isScanning = true;

  scanner.scan((successful, mesg, response) => {
    this.isScanning = false;

    if (!successful) {
      console.error('Scan failed:', mesg);
      alert('فشل المسح: ' + mesg);
      return;
    }

    // Store the map: scanned file => Arabic name
    this.fileNameMap[`${sanitizedName}.pdf`] = this.proposedFileName;

    localStorage.setItem(
  `fileNameMap_${this.employee.employee_number}`,
  JSON.stringify(this.fileNameMap)
);

    alert('تم حفظ الملف بنجاح.');
    this.fetchEmployee();
    this.proposedFileName = '';
  }, {
    output_settings: [{
      type: 'save',
      format: 'pdf',
      save_path: fullSavePath
    }]
  });
}
  }
};
</script>

<style scoped>
/* Add any styling here to adjust the UI for Arabic language */
</style>
