<template>
  <div>
    <NavigationBar />
    <router-view />
  </div>
</template>

<script>
import NavigationBar from "./NavigationBar.vue";

export default {
  name: "App",
  components: {
    NavigationBar,
  },
};
</script>
