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
      <form>
        <h5 class="fw-normal mb-5 pb-4" style="letter-spacing: 1px; margin-top: 50px;">Dados Pessoais:</h5>

        <div data-mdb-input-init class="form-outline mb-2">
          <label class="form-label" for="form2Example17">Nome Completo</label>
          <input type="text" id="form2Example17" class="form-control form-control" />
        </div>

        <h6 class="fw-normal mb-2 pb-3 tittle-form" style="letter-spacing: 1px;">Gênero:</h6>
        <div class="d-flex justify-content-center mb-3">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="genero" value="feminino" id="form2ExampleFeminino" />
            <label class="form-check-label" for="form2ExampleFeminino"> Femenino</label>
          </div>
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="genero" value="masculino" id="form2ExampleMasculino" />
            <label class="form-check-label" for="form2ExampleMasculino"> Masculino</label>
          </div>
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="genero" value="nao-binario"
              id="form2ExampleNaoBinario" />
            <label class="form-check-label" for="form2ExampleNaoBinario"> Não-Binário</label>
          </div>
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="genero" value="outros" id="form2ExampleOutros" />
            <label class="form-check-label" for="form2ExampleOutros"> Outros</label>
          </div>
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="genero" value="prefiro_nao_responder"
              id="form2ExamplePrefiroNaoResponder" />
            <label class="form-check-label" for="form2ExamplePrefiroNaoResponder"> Prefiro não responder</label>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <div data-mdb-input-init class="form-outline">
              <label class="form-label" for="form2Example27">CEP</label>
              <input type="text" id="form2Example27" class="form-control" />
            </div>
          </div>
          <div class="col-md-6">
            <div data-mdb-input-init class="form-outline">
              <label class="form-label" for="form2ExampleEndereço">Endereço</label>
              <input type="text" id="form2ExampleEndereço" class="form-control" />
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <div data-mdb-input-init class="form-outline">
              <label class="form-label" for="form2ExampleEstado">Estado</label>
              <input type="text" id="form2ExampleEstado" class="form-control" />
            </div>
          </div>
          <div class="col-md-6">
            <div data-mdb-input-init class="form-outline">
              <label class="form-label" for="form2ExampleCidade">Cidade</label>
              <input type="text" id="form2ExampleCidade" class="form-control" />
            </div>
          </div>
        </div>
      </form>
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

.tittle-form {
  font-size: 14px;
}
</style>