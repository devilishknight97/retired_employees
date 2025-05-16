<template>
    <div class="pdf-storage-section p-4 bg-gray-50 rounded-lg shadow-sm">
      <h2 class="text-3xl font-semibold mb-4 text-center">مستندات PDF</h2>
      
      <!-- Search Bar -->
      <div class="flex items-center mb-4">
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="ابحث عن الملف..." 
          class="flex-grow px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <button 
          @click="clearSearch" 
          class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700"
        >
          مسح
        </button>
      </div>
      
      <!-- PDFs List -->
      <div v-if="filteredPdfs.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div 
          v-for="(pdf, index) in filteredPdfs" 
          :key="index" 
          class="border p-4 rounded flex items-center justify-between hover:bg-gray-100"
        >
          <a :href="pdfUrl(pdf)" target="_blank" class="text-blue-500 hover:underline truncate">
            {{ pdf }}
          </a>
          <button 
            @click="downloadPdf(pdf)" 
            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
          >
            ⬇️
          </button>
        </div>
      </div>
      <div v-else class="text-center text-gray-600 py-4">
        لا يوجد ملفات PDF مطابقة
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "EmployeePdfStorage",
    props: {
      pdfs: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        searchQuery: ""
      };
    },
    computed: {
      filteredPdfs() {
        if (!this.searchQuery.trim()) return this.pdfs;
        return this.pdfs.filter(pdf =>
          pdf.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
    },
    methods: {
      clearSearch() {
        this.searchQuery = "";
      },
      pdfUrl(pdf) {
        // Assuming the PDFs are stored in "employee_documents" folder inside your public storage
        return `/storage/employee_documents/${pdf}`;
      },
      downloadPdf(pdf) {
        const link = document.createElement("a");
        link.href = this.pdfUrl(pdf);
        link.download = pdf;
        link.click();
      }
    }
  };
  </script>
  
  <style scoped>
  .pdf-storage-section {
    /* Additional styling as needed */
  }
  </style>
  