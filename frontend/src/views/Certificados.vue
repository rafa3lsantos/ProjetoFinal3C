<template>
    <div>
      <Navbar />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  
      <div class="container p-0">
        <div class="row">
          <div class="col-md-5 col-xl-4">
  
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Currículo</h5>
              </div>
  
              <div class="list-group list-group-flush" role="tablist">
                <router-link to="/dados-pessoais" class="list-group-item list-group-item-action active" role="tab">
                  Dados Pessoais
                </router-link>
                <router-link to="/experiencia-profissional" class="list-group-item list-group-item-action" role="tab">
                  Experiência Profissional
                </router-link>
                <router-link to="/formacao" class="list-group-item list-group-item-action" role="tab">
                  Formação
                </router-link>
                <router-link to="/certificados" class="list-group-item list-group-item-action" role="tab">
                  Conquistas ou certificados
                </router-link>
                <router-link to="/skills" class="list-group-item list-group-item-action" role="tab">
                  Skills
                </router-link>
                <router-link to="/idioma" class="list-group-item list-group-item-action" role="tab">
                  Idioma
                </router-link>
                <router-link to="/anexar-curriculo" class="list-group-item list-group-item-action" role="tab">
                  Anexar Currículo
                </router-link>
              </div>
  
            </div>
          </div>
  
          <div class="col-md-7 col-xl-8">
            <div class="tab-content">
              <div class="tab-pane fade show active" id="account" role="tabpanel">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Dados Pessoais</h5>
                  </div>
                  <div class="card-body">
                    <form>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputFirstName">Nome Completo</label>
                          <input type="text" class="form-control" id="inputFirstName" placeholder="Digite seu nome">
                        </div>
                      </div>
                      <div class="form-group">
                        <div>
                          <label>Gênero</label>
                          <div class="genero-options py-2">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male">
                              <label class="form-check-label" for="genderMale">Masculino</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female">
                              <label class="form-check-label" for="genderFemale">Feminino</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other">
                              <label class="form-check-label" for="genderOther">Não-Binário</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other">
                              <label class="form-check-label" for="genderOther">Outro</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other">
                              <label class="form-check-label" for="genderOther">Prefiro não responder</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">CEP</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Digite seu CEP">
                      </div>
                      <div class="form-group">
                        <label for="inputAddress2">Endereço</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Digite seu endereço">
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputState">Estado</label>
                          <select id="inputState" class="form-control">
                            <option selected="">Selecione seu estado</option>
                            <option>...</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputCity">Cidade</label>
                          <select id="inputCity" class="form-control">
                            <option selected="">Selecione sua cidade</option>
                            <option>...</option>
                          </select>
                        </div>
                      </div>
  
                      <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="password" role="tabpanel">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Password</h5>
                    <form>
                      <div class="form-group">
                        <label for="inputPasswordCurrent">Current password</label>
                        <input type="password" class="form-control" id="inputPasswordCurrent">
                        <small><a href="#">Forgot your password?</a></small>
                      </div>
                      <div class="form-group">
                        <label for="inputPasswordNew">New password</label>
                        <input type="password" class="form-control" id="inputPasswordNew">
                      </div>
                      <div class="form-group">
                        <label for="inputPasswordNew2">Verify password</label>
                        <input type="password" class="form-control" id="inputPasswordNew2">
                      </div>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                  </div>
                </div>
              </div>
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
  }
  </script>
  
  <style scoped>
  body {
    margin-top: 20px;
    background: #F0F8FF;
  }
  
  .card {
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
  }
  
  .card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e5e9f2;
    border-radius: .2rem;
  }
  
  .card-header:first-child {
    border-radius: calc(.2rem - 1px) calc(.2rem - 1px) 0 0;
  }
  
  .card-header {
    border-bottom-width: 1px;
  }
  
  .card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    color: inherit;
    background-color: #fff;
    border-bottom: 1px solid #e5e9f2;
  }
  
  .save {
    margin-top: 20px;
  }
  
  .genero-options {
    display: flex;
    flex-wrap: wrap;
  }
  
  .form-check {
    margin-right: 15px;
  }
  
  .form-check:last-child {
    margin-right: 0;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  </style>
  