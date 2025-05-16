<template>
  <div class="container mx-auto p-4 text-right" dir="rtl">
    <h1 class="text-3xl font-bold mb-6 text-center">قائمة الموظفين</h1>

    <!-- Search Form -->
    <form @submit.prevent="searchEmployees" class="mb-4 flex justify-center">
      <input 
        type="text" 
        v-model="searchQuery" 
        placeholder="أبحث برقم أو إسم الموظف"
        class="w-1/3 px-3 py-1.5 text-sm border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 text-right"
      />
      <button type="submit" class="mr-2 bg-blue-500 text-white px-3 py-1.5 text-sm rounded hover:bg-blue-700">
        بحث
      </button>
      <button type="button" @click="clearSearch" class="mr-2 bg-gray-500 text-white px-3 py-1.5 text-sm rounded hover:bg-gray-700">
        مسح
      </button>
      
    </form>

    <!-- Employee List -->
    <div v-if="employees.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <div 
        v-for="employee in employees" 
        :key="employee.employee_number" 
        class="bg-white shadow-sm rounded-md p-4 hover:shadow-md transition-shadow flex flex-col justify-between h-full"
      >
        <div class="flex items-center justify-between mb-3">
          <div class="ml-4">
            <img
              :src="employee.picture_url"
              alt="Avatar"
              class="w-16 h-16 rounded-full object-cover border"
            />
          </div>
          <div class="flex-1 text-right">
            <h2 class="text-lg font-semibold mb-1">{{ employee.full_name }}</h2>
            <p class="text-sm text-gray-600 mb-1"><strong>الرقم الوظيفي:</strong> {{ employee.employee_number }}</p>
            <p class="text-sm text-gray-600 mb-1"><strong>مكان العمل:</strong> {{ employee.workplace }}</p>
          </div>
        </div>
        <router-link 
          :to="`/app/employee/${employee.employee_number}`" 
          class="bg-blue-500 text-white px-3 py-1 text-xs rounded hover:bg-blue-700 block text-center"
        >
          عرض المعلومات
        </router-link>
      </div>
    </div>

    <div v-else class="text-center text-gray-500 text-sm">
      لم يتم العثور على الموظف
    </div>
  </div>
  
</template>

<script>
import axios from '@/axios.js';

export default {
  name: "EmployeesContainer",
  data() {
    return {
      employees: [],
      searchQuery: "",
    };
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    fetchEmployees() {
      axios.get("/employees")
        .then(response => {
          console.log(response)
          this.employees = response.data;
        })
        .catch(error => {
          console.error("Error fetching employees:", error);
        });
    },
    searchEmployees() {
      if (!this.searchQuery.trim()) {
        this.fetchEmployees();
        return;
      }
      axios.get("/app/employees/search", {
        params: { query: this.searchQuery }
      })
      .then(response => {
        this.employees = response.data;
      })
      .catch(error => {
        console.error("Error searching employees:", error);
      });
    },
    clearSearch() {
      this.searchQuery = "";
      this.fetchEmployees();
    }
  }
};
</script>

<style scoped>
/* Additional RTL-specific styles if needed */
</style>