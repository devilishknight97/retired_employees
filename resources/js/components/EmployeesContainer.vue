<template>
  <div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8 text-center">Employee List</h1>

    <div v-if="employees.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div 
        v-for="employee in employees" 
        :key="employee.employee_number" 
        class="bg-white shadow-md rounded-lg p-6 hover:shadow-xl transition-shadow"
      >
        <h2 class="text-2xl font-semibold mb-2">{{ employee.full_name }}</h2>
        <p class="text-gray-700"><strong>Employee #:</strong> {{ employee.employee_number }}</p>
        <p class="text-gray-700"><strong>Workplace:</strong> {{ employee.workplace }}</p>
        <p class="text-gray-700"><strong>Start Date:</strong> {{ employee.start_work_date }}</p>
        <p class="text-gray-700"><strong>Birthdate:</strong> {{ employee.birthdate }}</p>

        <div class="mt-4 flex space-x-2">
          <router-link 
            :to="'/edit/' + employee.employee_number" 
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Edit
          </router-link>
          <button 
            @click="deleteEmployee(employee.employee_number)" 
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <div v-else class="text-center text-gray-500">
      No employees found.
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      employees: [],
    };
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    fetchEmployees() {
      axios.get("/employees")
        .then((response) => {
          console.log("Employee data:", response.data);
          this.employees = response.data;
        })
        .catch((error) => {
          console.error("Error fetching employees:", error);
        });
    },
    deleteEmployee(employee_number) {
      if (confirm("Are you sure you want to delete this employee?")) {
        axios.delete(`/employees/${employee_number}`)
          .then(() => {
            this.employees = this.employees.filter(emp => emp.employee_number !== employee_number);
          })
          .catch((error) => {
            console.error("Error deleting employee:", error);
          });
      }
    },
  },
};
</script>
