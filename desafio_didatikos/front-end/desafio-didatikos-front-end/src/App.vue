<template>
  <Navbar />
  <main>
    <router-view />
  </main>
</template>

<script>
import Navbar from "./components/navbar/Navbar.vue";

export default {
  name: "App",
  components: {
    Navbar,
  },
};
</script>

<style>
#app {
  font-family: "Arial, sans-serif";
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 100vh;
  width: 100vw;
}

main {
  flex: 1;
  padding: 20px;
  text-align: center;
}
</style>
