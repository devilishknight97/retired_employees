<template>
  <div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">تعديل البيانات</h1>

    <form @submit.prevent="updateEmployee">
      <label class="block mb-2">الإسم بالكامل</label>
      <input v-model="employee.full_name" type="text" class="border p-2 w-full mb-4" required>

      <label class="block mb-2">القسم</label>
      <input v-model="employee.workplace" type="text" class="border p-2 w-full mb-4">

      <label class="block mb-2">تاريخ بداية العمل</label>
      <input v-model="employee.start_work_date" type="date" class="border p-2 w-full mb-4" required>

      <label class="block mb-2">تاريخ الميلاد</label>
      <input v-model="employee.birthdate" type="date" class="border p-2 w-full mb-4" required>

      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
        حفظ التغييرات
      </button>
    </form>
  </div>
</template>

<script>
import axios from '@/axios.js';

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
    async fetchEmployee() {
      try {
        const res = await axios.get(`/employees/${this.$route.params.employee_number}`);
        if (typeof res.data !== "object") {
          console.error("Invalid response data:", res.data);
          return;
        }
        this.employee = res.data;
      } catch (error) {
        console.error("Error fetching employee:", error.response?.data || error);
      }
    },
    async updateEmployee() {
      try {
        await axios.put(`/employees/${this.$route.params.employee_number}`, this.employee);
        alert("تم تحديث البيانات بنجاح");
        this.$router.push('/app/employees');
      } catch (error) {
        console.error("Update error:", error.response?.data || error);
        alert("فشل تحديث البيانات");
      }
    }
  }
};
</script>
