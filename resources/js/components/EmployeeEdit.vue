<template>
    <div class="container mx-auto p-8">
      <h1 class="text-3xl font-bold mb-4">Edit Employee</h1>
      
      <form @submit.prevent="updateEmployee">
        <label class="block mb-2">Full Name:</label>
        <input v-model="employee.full_name" type="text" class="border p-2 w-full mb-4" required>
  
        <label class="block mb-2">Workplace:</label>
        <input v-model="employee.workplace" type="text" class="border p-2 w-full mb-4">
  
        <label class="block mb-2">Start Work Date:</label>
        <input v-model="employee.start_work_date" type="date" class="border p-2 w-full mb-4" required>
  
        <label class="block mb-2">Birthdate:</label>
        <input v-model="employee.birthdate" type="date" class="border p-2 w-full mb-4" required>
  
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
          Save Changes
        </button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        employee: {
          full_name: "",
          workplace: "",
          start_work_date: "",
          birthdate: "",
        },
      };
    },
    mounted() {
      this.fetchEmployee();
    },
    methods: {
      fetchEmployee() {
        axios
    .get(`/employees/${this.$route.params.employee_number}`)
    .then((response) => {
      if (typeof response.data === "string") {
        console.error("Received HTML instead of JSON. Possible API error.");
        return;
      }
      this.employee = response.data;
    })
    .catch((error) => {
      console.error("Error fetching employee:", error.response?.data || error);
    });
      },
      updateEmployee() {
        axios
          .put(`/employees/${this.$route.params.employee_number}`, this.employee)
          .then(() => {
            alert("Employee updated successfully!");
            this.$router.push("/employees");
          })
          .catch((error) => {
            console.error("Error updating employee:", error);
          });
      },
    },
  };
  </script>
  