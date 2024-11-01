<template>
    <div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group list-group-flush" role="tablist">
              <a class="list-group-item list-group-item-action" @click="showSection('dadosPessoais')">
                Dados Pessoais
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('experienciaProfissional')">
                Experiência Profissional
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('formacao')">
                Formação
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('certificados')">
                Conquistas ou certificados
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('skills')">
                Skills
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('idioma')">
                Idioma
              </a>
              <a class="list-group-item list-group-item-action" @click="showSection('anexarCurriculo')">
                Anexar Currículo
              </a>
            </div>
          </div>
  
          <div class="col-md-9">
            <div v-if="currentSection === 'dadosPessoais'">
              <h2>Dados Pessoais</h2>
              <!-- conteúdo de Dados Pessoais -->
            </div>
            <div v-if="currentSection === 'experienciaProfissional'">
              <h2>Experiência Profissional</h2>
              <!-- conteúdo de Experiência Profissional -->
            </div>
            <div v-if="currentSection === 'formacao'">
              <h2>Formação</h2>
              <!-- conteúdo de Formação -->
            </div>
            <div v-if="currentSection === 'certificados'">
              <h2>Conquistas ou certificados</h2>
              <!-- conteúdo de Certificados -->
            </div>
            <div v-if="currentSection === 'skills'">
              <h2>Skills</h2>
              <!-- conteúdo de Skills -->
            </div>
            <div v-if="currentSection === 'idioma'">
              <h2>Idioma</h2>
              <!-- conteúdo de Idioma -->
            </div>
            <div v-if="currentSection === 'anexarCurriculo'">
              <h2>Anexar Currículo</h2>
              <!-- conteúdo de Anexar Currículo -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  export default {
    
    data() {
      return {
        currentSection: 'dadosPessoais', // Seção inicial a ser exibida
      };
    },
    methods: {
      showSection(section) {
        this.currentSection = section; // Altera a seção atual
      },
    },
  };
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
  