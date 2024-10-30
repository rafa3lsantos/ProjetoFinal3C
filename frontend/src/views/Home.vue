<template>
  <div>
    <Navbar />
    <SearchMain />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import SearchMain from '@/components/SearchMain.vue';

export default {
    name: 'Home',
    components: {
        Navbar,
        SearchMain
    }

}
</script>

<style>

</style>