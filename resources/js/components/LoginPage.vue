<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100" dir="rtl">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img src="/public/assets/logo.png" alt="شعار التطبيق" class="h-16 w-auto" />
      </div>
      <h1 class="text-4xl font-bold text-center mb-4">منظومة التقاعد</h1>
      <h2 class="text-2xl font-bold text-center mb-4">تسجيل الدخول</h2>
      <input
        v-model="username"
        type="text"
        placeholder="اسم المستخدم"
        class="w-full p-2 mb-2 border border-gray-300 rounded text-right"
      />
      <input
        v-model="password"
        type="password"
        placeholder="كلمة المرور"
        class="w-full p-2 mb-4 border border-gray-300 rounded text-right"
      />
      <button
        @click="login"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded transition duration-300"
      >
        دخول
      </button>
      <p v-if="errorMessage" class="text-red-500 text-center mt-4">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script>
import axios from "@/axios.js";
export default {
  data() {
    return {
      username: "",
      password: "",
      errorMessage: ""
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("/app/login", {
          username: this.username,
          password: this.password,
        });
        localStorage.setItem("token", response.data.token);
        this.$router.push("/app/");
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "فشل تسجيل الدخول";
      }
    },
  },
};
</script>

<style scoped>
/* تحويل جميع النصوص إلى محاذاة لليمين لتناسب اللغة العربية */
input,
button {
  text-align: center;
}
/* تخصيص ألوان إضافية إذا لزم الأمر */
</style>