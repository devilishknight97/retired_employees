<template>
    <nav class="bg-blue-500 p-4 text-white flex justify-between">
        <div class="text-lg font-bold">الموظفين المتقاعدين</div>
        <ul class="flex space-x-4">
            <li><router-link to="/app" class="hover:underline">الرئيسية</router-link></li>
            <li><router-link to="/app/employees" class="hover:underline">الموظفين</router-link></li>
            <li><router-link to="/app/add-employee" class="hover:underline">إضافة موظف</router-link></li>
            <button @click="exitApp" class=" text-red-600 hover:underline" > تسجيل خروج</button>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "NavigationBar",
  methods: {
    exitApp() {
      localStorage.removeItem("token"); // Clears authentication token (if used)
      window.close(); // Attempts to close the tab (some browsers might block this)
      this.$router.push({ name: "Login" }); // Redirect to login if tab doesn't close
    }
  }
};

</script>
