<template>
  <div>
    <Navbar />
    <div class="box-lateral">
      <div class="img-user">
        <img width="180px" src="../../public/user.png" alt="user">
      </div>
      <div class="name-user">
        <h5>João da Silva</h5>
        <h6>Desenvolvedor</h6>
      </div>
    </div>
    <div class="menu-lateral-box">
      <div class="menu-lateral">
        <ul class="menu-lateral-list">
          <li><a href="">Dados Pessoais</a></li>
          <li><a href="">Experiência Profissional</a></li>
          <li><a href="">Formações</a></li>
          <li><a href="">Conquistas ou certificados</a></li>
          <li><a href="">Skills</a></li>
          <li><a href="">Anexar Currículo</a></li>
        </ul>
      </div>
    </div>
    <div class="content">
      <div class="info-box">
        <div class="box-inner">
          <div class="seus-dados">
            <h3>Dados pessoais <span class="edit-icon">✎</span></h3>
            <p>Nome:</p>
            <p>Deficiência:</p>
            <p>Endereço:</p>
            <p>Idioma:</p>
            <p>Nível:</p>

          </div>

          <div class="formacao">
            <h3>Formação <span class="edit-icon">✎</span></h3>
            <p>Grau:</p>
            <p>Status:</p>
            <p>Curso:</p>
            <p>Instituição:</p>
            <p>Fim:</p>
            <p>Início:</p>
          </div>

          <div class="experiencia-profissional">
            <h3>Experiência Profissional <span class="edit-icon">✎</span></h3>
            <p>Empresa:</p>
            <p>Cargo:</p>
            <p>Início:</p>
            <p>Fim:</p>
            <p>Descrição das atividades:</p>
          </div>

          <div class="skills">
            <h3>Skills <span class="edit-icon">✎</span></h3>
            <p>Soft skill:</p>
            <p>Hard skill:</p>
          </div>

          <div class="conquistas">
            <h3>Conquistas ou Certificados <span class="edit-icon">✎</span></h3>
            <p>Conquistas ou certificados:</p>
            <p>Título:</p>
            <p>Descrição:</p>
          </div>



          <div class="curriculo">
            <h3>Currículo <span class="edit-icon">✎</span></h3>
            <p>curriculo_joao.pdf</p>
          </div>
        </div>
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
  flex-direction: column;
  align-items: center;
  height: 300px;
  width: 25%;
  border: 1px solid #000;
}

.img-user {
  margin-top: 30px;
}

.name-user {
  margin-top: 15px;
  text-align: center;
}

.menu-lateral-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 409px;
  width: 25%;
  border-right: 1px solid #000;
  border-bottom: 1px solid #000;
  border-left: 1px solid #000;
}

.menu-lateral {
  width: 100%;
}

.menu-lateral-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
  width: 100%;
}

.menu-lateral li {
  width: 100%;
}

.menu-lateral li:hover {
  background-color: #e0e0e0;
}

.menu-lateral a {
  text-decoration: none;
  color: #000;
  font-weight: bold;
  display: block;
  padding: 15px;
  text-align: center;
  transition: background-color 0.3s, color 0.3s;
}

.content {
  display: flex;
  width: 75%;
  position: absolute;
  right: 0px;
  margin-top: -709px;
  max-height: 709px;
  border-bottom: 1px solid #000;
  font-size: 14px;
}

.info-box {
  width: 100%;
  padding: 20px;
  height: 709px;
}

.box-inner {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.seus-dados,
.formacao,
.experiencia-profissional,
.skills,
.curriculo,
.conquistas{
  flex: 1 1 calc(30% - 20px);
  box-sizing: border-box;
  padding: 10px;
  border-radius: 5px;
}

.seus-dados h3,
.formacao h3,
.experiencia-profissional h3,
.skills h3,
.curriculo h3,
.conquistas h3 {
  font-size: 18px;
}




.edit-icon {
  font-size: 0.9em;
  cursor: pointer;
  color: #007bff;
}
</style>
