<template>
  <div>
    <RouterView />
  </div>
</template>

<script>
import { RouterView } from 'vue-router';
import Navbar from './components/Navbar.vue';
import SearchMain from './components/SearchMain.vue';

export default {
  name: 'App',
  components: {
    Navbar,
    SearchMain
  }
}
</script>

<style scoped></style>
