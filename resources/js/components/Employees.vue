<!-- resources/js/pages/LandingPage.vue -->
<template>
  <div class="container mx-auto p-8 text-center">
    <h1 class="text-4xl font-bold mb-8">الصفحة الرئيسية</h1>
    <button @click="$router.push('/app/employees')" class="btn-primary mr-4">
      قائمة الموظفين
    </button>
    <button @click="$router.push('/app/add-employee')" class="btn-secondary">
      إضافة موظف
    </button>
  </div>
</template>

<script>
export default {
  name: 'RetiredEmployees'
};
</script>

<style scoped>
.btn-primary {
  background-color: #3b82f6;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
}
.btn-secondary {
  background-color: #10b981;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
}
</style>
