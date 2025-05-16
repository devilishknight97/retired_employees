<template>
  <div class="max-w-4xl mx-auto p-8 mt-6 bg-white shadow-md rounded-lg texet-right" dir="rtl">
    <h1 class="text-3xl font-bold text-center mb-6">إضافة موظف</h1>
    
    <form @submit.prevent="addEmployee">
      <!-- Employee Number -->
       <div class="grid grid-cols-2 gap-4">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2"> الرقم الوظيفي</label>
        <input v-model="employee.employee_number" type="number" class="w-full p-2 border rounded" required>
      </div>

      <!-- Full Name -->
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">الإسم بالكامل</label>
        <input v-model="employee.full_name" type="text" class="w-full p-2 border rounded" required>
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- Workplace -->
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">القسم</label>
        <input v-model="employee.workplace" type="text" class="w-full p-2 border rounded">
      </div>

      <!-- Start Work Date -->
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">  تاريخ بداية العمل</label>
        <input v-model="employee.start_work_date" type="date" class="w-full p-2 border rounded" required>
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- Birthdate -->
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">تاريخ الميلاد</label>
        <input v-model="employee.birthdate" type="date" class="w-full p-2 border rounded" required>
      </div>

         <!-- تاريخ التعييت بالأجر اليومي -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ التعيين بالأجر اليومي</label>
        <select v-model="employee.daily_wage_appointment_date" class="w-full p-2 border rounded mb-1">
          <option value="">لا يوجد</option>
        </select>
        <input v-model="employee.daily_wage_appointment_date" type="date" class="w-full p-2 border rounded" />
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- تاريخ التعيين بموجب عقد -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ التعيين بموجب عقد</label>
        <select v-model="employee.contract_appointment_date" class="w-full p-2 border rounded mb-1">
          <option value="">لا يوجد</option>
        </select>
        <input v-model="employee.contract_appointment_date" type="date" class="w-full p-2 border rounded" />
      </div>

      <!-- تاريخ التصنيف أو التعيين -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ التصنيف أو التعيين</label>
        <select v-model="employee.official_appointment_date" class="w-full p-2 border rounded mb-1">
          <option value="">لا يوجد</option>
        </select>
        <input v-model="employee.official_appointment_date" type="date" class="w-full p-2 border rounded" />
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- الدرجة عند التعيين -->
      <div class="mb-4">
        <label class="block mb-2">الدرجة عند التعيين</label>
        <input v-model="employee.grade_at_appointment" class="w-full p-2 border rounded">
         
      </input>
      </div>

      <!-- الدرجة عند الإحالة -->
      <div class="mb-4">
        <label class="block mb-2">الدرجة عند الإحالة</label>
        <input v-model="employee.grade_at_retirement" class="w-full p-2 border rounded">
        </input>
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- تاريخ الحصول على الدرجة -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ الحصول على الدرجة</label>
        <input v-model="employee.grade_received_date" type="date" class="w-full p-2 border rounded" />
      </div>

      <!-- تاريخ النقل الى الميناء -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ النقل الى الميناء</label>
        <select v-model="employee.port_transfer_date" class="w-full p-2 border rounded mb-1">
          <option value="">لا يوجد</option>
        </select>
        <input v-model="employee.port_transfer_date" type="date" class="w-full p-2 border rounded" />
      </div>
</div>
 <div class="grid grid-cols-2 gap-4">
      <!-- الجهة المنتقل منها -->
      <div class="mb-4">
        <label class="block mb-2">الجهة المنتقل منها</label>
        <input v-model="employee.previous_department" class="w-full p-2 border rounded">
        </input>
      </div>

      <!-- تاريخ إنهاء الخدمة -->
      <div class="mb-4">
        <label class="block mb-2">تاريخ إنهاء الخدمة</label>

        <input v-model="employee.service_termination_date" type="date" class="w-full p-2 border rounded" />
      </div>
</div>
      <!-- سبب إنهاء الخدمة -->
      <div class="mb-4">
        <label class="block mb-2">سبب إنهاء الخدمة</label>
        <select v-model="employee.termination_reason" class="w-full p-2 border rounded" required>
          <option disabled value="">اختر السبب</option>
          <option>بلوغ السنة القانونية</option>
          <option>تقاعد إختياري</option>
          <option>بسبب الوفاة</option>
          <option>فصل من العمل</option>
          <option>العجز الطبي</option>
        </select>
      </div>


      <!-- Submit Button -->
       <div class="text-center">
      <button type="submit" class=" w-1/3 bg-blue-500 text-white py-2 rounded hover:bg-blue-700 transition">
        إضافة
      </button></div>
    </form>
    
    
      <div
  v-if="showSuccessPopup"
  class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30"
>
  <div class="bg-green-100 border border-green-400 text-green-800 px-10 py-6 rounded-2xl shadow-xl w-[400px] text-center relative">
    <h2 class="text-lg">تم حفظ البيانات بنجاح</h2>
    <button
      @click="closePopup"
      class="mt-5 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
    >
      إغلاق
    </button>
  </div>
</div>
  </div>
  <!-- Success Message -->


</template>

<script>
import axios from '@/axios.js';

export default {
  data() {
    return {
      employee: {
        employee_number: '',
        full_name: '',
        workplace: '',
        start_work_date: '',
        birthdate: '',
        daily_wage_appointment_date: '',
        contract_appointment_date: '',
        official_appointment_date: '',
        grade_at_appointment: '',
        grade_at_retirement: '',
        grade_received_date: '',
        port_transfer_date: '',
        previous_department: '',
        service_termination_date: '',
        termination_reason: '',
      },
      showSuccessPopup: false,
      autoCloseTimer: null
    };
  },
  methods: {
    addEmployee() {
      axios.post('/employees', this.employee)
        .then(response => {
          this.triggerSuccessPopup(); // ✅ show success
          this.resetForm();           // ✅ clear the form
        })
        .catch(error => {
          console.error("Error adding employee:", error.response);
        });
    },
    resetForm() {
      const keys = Object.keys(this.employee);
      keys.forEach(k => this.employee[k] = '');
    },
    triggerSuccessPopup() {
      this.showSuccessPopup = true;

      // Clear previous timer if it exists
      if (this.autoCloseTimer) clearTimeout(this.autoCloseTimer);

      // Auto close after 3 seconds
      this.autoCloseTimer = setTimeout(() => {
        this.showSuccessPopup = false;
      }, 3000);
    },
    closePopup() {
      this.showSuccessPopup = false;

      // Cancel auto-close if user closes manually
      if (this.autoCloseTimer) clearTimeout(this.autoCloseTimer);
    }
  }
};
</script>

