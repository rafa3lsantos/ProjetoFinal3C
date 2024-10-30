<template>
  <div>
    <Navbar />
    <div class="box-lateral">
      <div class="img-user">
        <img width="180px" src="../../public/user.png" alt="user">
      </div>
      <div class="name-user">
        <h5>João da silva</h5>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';

export default {
  name: 'PerfilCandidato',
  components: {
    Navbar
  }
};
</script>

<style scoped>
.box-lateral {
  margin-top: -24px;
  display: flex;
  justify-content: center;
  height: 300px;
  width: 25%;
  background-color: #ccc;
}

.img-user {
  max-width: 100%;
  max-height: 100%;
  margin-top: 30px;
}

.name-user {
  margin-top: 250px;
}
</style>