<template>
  <div class="max-w-lg mx-auto p-8 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-center mb-6">إضافة موظف</h1>
    
    <form @submit.prevent="addEmployee">
      <!-- Employee Number -->
      <div class="mb-4">
        <label class="block text-gray-700"> الرقم الوظيفي</label>
        <input v-model="employee.employee_number" type="number" class="w-full p-2 border rounded" required>
      </div>

      <!-- Full Name -->
      <div class="mb-4">
        <label class="block text-gray-700">الإسم بالكامل</label>
        <input v-model="employee.full_name" type="text" class="w-full p-2 border rounded" required>
      </div>

      <!-- Workplace -->
      <div class="mb-4">
        <label class="block text-gray-700">القسم</label>
        <input v-model="employee.workplace" type="text" class="w-full p-2 border rounded">
      </div>

      <!-- Start Work Date -->
      <div class="mb-4">
        <label class="block text-gray-700">  تاريخ بداية العمل</label>
        <input v-model="employee.start_work_date" type="date" class="w-full p-2 border rounded" required>
      </div>

      <!-- Birthdate -->
      <div class="mb-4">
        <label class="block text-gray-700">تاريخ الميلاد</label>
        <input v-model="employee.birthdate" type="date" class="w-full p-2 border rounded" required>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-700 transition">
        إضافة
      </button>
    </form>
    
    <!-- Success Message -->
    <p v-if="successMessage" class="text-green-500 text-center mt-4">{{ successMessage }}</p>
    
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      employee: {
        employee_number: '',
        full_name: '',
        workplace: '',
        start_work_date: '',
        birthdate: ''
      },
      successMessage: ''
    };
  },
  methods: {
    addEmployee() {
      axios.post('/employees', this.employee)
        .then(response => {
          this.successMessage = "Employee added successfully!";
          this.resetForm(); // ✅ This is now correctly placed inside the then() block
        })
        .catch(error => {
          console.error("Error adding employee:", error);
        });
    },
    resetForm() {
      this.employee = {
        employee_number: '',
        full_name: '',
        workplace: '',
        start_work_date: '',
        birthdate: ''
      };
    }
  } 
};
</script>