<template>
  <div id="nav" class="bg-purple-500 text-white">
    <div class="container flex justify-between py-6">
      <div class="text-3xl font-normal">
        <router-link to="/" class="hover:text-gray-300 active:text-white"
          >BookStore</router-link
        >
      </div>
      <div class="text-lg">
        <router-link to="/" class="hover:text-gray-300 cursor-pointer"
          >Home</router-link
        >
        <router-link to="/info" class="hover:text-gray-300 pl-6 cursor-pointer"
          >Info</router-link
        >
      </div>
    </div>
  </div>
  <div class="container">
    <router-view></router-view>
  </div>
  <!-- <Footer /> -->
</template>
<script>
import Footer from "./components/Footer.vue";
export default {
  data() {},
  components: { Footer },
};
</script>

<style>
.container {
  width: 100%;
  margin-right: auto;
  margin-left: auto;
  padding-right: 1rem;
  padding-left: 1rem;
}
</style>
