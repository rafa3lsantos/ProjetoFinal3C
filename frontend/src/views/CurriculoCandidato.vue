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
        </div>

        <div class="col-md-7 col-xl-8">
          <div v-if="currentSection === 'dadosPessoais'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Dados Pessoais</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="nomeCandidato">Nome Completo</label>
                      <input type="text" class="form-control" id="nomeCandidato" placeholder="Digite seu nome">
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <label>Gênero</label>
                      <div class="genero-options py-2">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="masculino" value="masculino">
                          <label class="form-check-label" for="genderMale">Masculino</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="feminino" value="feminino">
                          <label class="form-check-label" for="genderFemale">Feminino</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="naoBinario"
                            value="nao-binario">
                          <label class="form-check-label" for="genderOther">Não-Binário</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="outro" value="outro">
                          <label class="form-check-label" for="genderOther">Outro</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="semResposta"
                            value="sem-resposta">
                          <label class="form-check-label" for="genderOther">Prefiro não responder</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="emailCandidato">Email</label>
                    <input type="email" class="form-control" id="emailCandidato" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="cepCandidato">CEP</label>
                    <input type="text" class="form-control" id="cepCandidato" placeholder="Digite seu CEP">
                  </div>
                  <div class="form-group">
                    <label for="enderecoCandidato">Endereço</label>
                    <input type="text" class="form-control" id="enderecoCandidato" placeholder="Digite seu endereço">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="estadoCandidato">Estado</label>
                      <select id="estadoCandidato" class="form-control">
                        <option selected="">Selecione seu estado</option>
                        <option>...</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="cidadeCandidato">Cidade</label>
                      <select id="cidadeCandidato" class="form-control">
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

          <div v-if="currentSection === 'experienciaProfissional'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Experiência Profissional</h5>
              </div>
              <div class="card-body">
                <form>
                  <div v-for="(experiencia, index) in experiencias" :key="index">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="empresa{{ index }}">Empresa</label>
                        <input type="text" class="form-control" :id="'empresa' + index" v-model="experiencia.empresa"
                          placeholder="Digite o nome da empresa">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="cargo{{ index }}">Cargo</label>
                          <input type="text" class="form-control" :id="'cargo' + index" v-model="experiencia.cargo"
                            placeholder="Cargo que exercia">
                        </div>
                      </div>
                      <div>
                        <label>Meu emprego Atual</label>
                        <div class="genero-options py-2">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="experiencia.empregoAtual">
                            <label class="form-check-label">Emprego Atual</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inicio{{ index }}">Início</label>
                        <input type="text" class="form-control" :id="'inicio' + index" v-model="experiencia.inicio"
                          placeholder="dd/mm/aaaa">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="fim{{ index }}">Fim</label>
                        <input type="text" class="form-control" :id="'fim' + index" v-model="experiencia.fim"
                          placeholder="dd/mm/aaaa">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="descricao{{ index }}">Descrição das atividades</label>
                        <textarea class="form-control" :id="'descricao' + index" v-model="experiencia.descricao"
                          rows="4" placeholder="Descreva as atividades..."></textarea>
                      </div>
                    </div>
                  </div>

                  <div>
                    <a href="#" @click.prevent="adicionarExperiencia" class="disabled-link">
                      <img width="20" src="../../public/add.png" alt="">
                      Adicionar outra experiência profissional.
                    </a>
                  </div>

                  <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>
          <div v-if="currentSection === 'formacao'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Formação</h5>
              </div>
              <div class="card-body">
                <form>
                  <div v-for="(formacao, index) in formacoes" :key="index">
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="formacao{{ index }}">Formação</label>
                        <select id="'formacao' + index" class="form-control" v-model="formacao.formacao">
                          <option selected="">Selecione a formação</option>
                          <option>Graduação</option>
                          <option>Pós-Graduação</option>
                          <option>Técnico</option>
                          <option>Outro</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="grau{{ index }}">Grau</label>
                        <select id="'grau' + index" class="form-control" v-model="formacao.grau">
                          <option selected="">Selecione o grau</option>
                          <option>Bacharel</option>
                          <option>Licenciatura</option>
                          <option>Tecnólogo</option>
                          <option>Mestrado</option>
                          <option>Doutorado</option>
                          <option>Outro</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="status{{ index }}">Status</label>
                        <select id="'status' + index" class="form-control" v-model="formacao.status">
                          <option selected="">Selecione o status</option>
                          <option>Concluído</option>
                          <option>Cursando</option>
                          <option>Trancado</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="curso{{ index }}">Curso</label>
                        <input type="text" class="form-control" :id="'curso' + index" v-model="formacao.curso"
                          placeholder="Nome do curso">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="instituicao{{ index }}">Instituição</label>
                        <input type="text" class="form-control" :id="'instituicao' + index"
                          v-model="formacao.instituicao" placeholder="Nome da instituição">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="inicio{{ index }}">Início</label>
                        <input type="text" class="form-control" :id="'inicio' + index" v-model="formacao.inicio"
                          placeholder="dd/mm/aaaa">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="fim{{ index }}">Fim</label>
                        <input type="text" class="form-control" :id="'fim' + index" v-model="formacao.fim"
                          placeholder="dd/mm/aaaa">
                      </div>
                    </div>
                  </div>

                  <div>
                    <a href="#" @click.prevent="adicionarFormacao" class="disabled-link">
                      <img width="20" src="../../public/add.png" alt="">
                      Adicionar outra formação.
                    </a>
                  </div>

                  <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>



          <div v-if="currentSection === 'certificados'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Conquistas ou Certificados</h5>
              </div>
              <div class="card-body">
                <form>
                  <div v-for="(item, index) in conquistasCertificados" :key="index">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label :for="'tipo' + index">Tipo</label>
                        <select class="form-control" :id="'tipo' + index" v-model="item.tipo">
                          <option value="">Selecione...</option>
                          <option value="Conquista">Conquista</option>
                          <option value="Certificado">Certificado</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label :for="'titulo' + index">Título</label>
                        <input type="text" class="form-control" :id="'titulo' + index" v-model="item.titulo"
                          placeholder="Digite o título">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label :for="'descricao' + index">Descrição</label>
                        <textarea class="form-control" :id="'descricao' + index" v-model="item.descricao" rows="4"
                          placeholder="Descreva..."></textarea>
                      </div>
                    </div>
                  </div>
                  <div>
                    <a href="#" @click.prevent="adicionarConquistaCertificado" class="disabled-link">
                      <img width="20" src="../../public/add.png" alt="">
                      Adicionar Conquista ou Certificado
                    </a>
                  </div>


                  <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>

          <div v-if="currentSection === 'skills'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Skills</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="form-group">
                    <label for="softSkills">Soft Skills</label>
                    <div class="input-group">
                      <input type="text" class="form-control" v-model="newSoftSkill"
                        placeholder="Adicione uma soft skill">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="addSoftSkill">Adicionar</button>
                      </div>
                    </div>
                    <div class="mt-2">
                      <span v-for="(skill, index) in softSkills" :key="index" class="badge skill-badge mr-1">
                        {{ skill }} <button type="button" class="close" @click="removeSoftSkill(index)">&times;</button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="hardSkills">Hard Skills</label>
                    <div class="input-group">
                      <input type="text" class="form-control" v-model="newHardSkill"
                        placeholder="Adicione uma hard skill">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="addHardSkill">Adicionar</button>
                      </div>
                    </div>
                    <div class="mt-2">
                      <span v-for="(skill, index) in hardSkills" :key="index" class="badge skill-badge mr-1">
                        {{ skill }} <button type="button" class="close" @click="removeHardSkill(index)">&times;</button>
                      </span>
                    </div>
                  </div>

                  <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>


          <div v-if="currentSection === 'idioma'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Idiomas</h5>
              </div>
              <div class="card-body">
                <form @submit.prevent="salvarIdiomas">
                  <div v-for="(idioma, index) in idiomas" :key="index" class="form-row mb-3">
                    <div class="form-group col-md-6">
                      <label :for="'idioma' + index">Idioma</label>
                      <input type="text" class="form-control" :id="'idioma' + index" v-model="idioma.nome"
                        placeholder="Digite o idioma">
                    </div>
                    <div class="form-group col-md-6">
                      <label :for="'nivel' + index">Nível</label>
                      <select :id="'nivel' + index" class="form-control" v-model="idioma.nivel">
                        <option value="" disabled>Selecione o nível</option>
                        <option>Iniciante</option>
                        <option>Intermediário</option>
                        <option>Avançado</option>
                        <option>Fluente</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <a href="#" @click.prevent="adicionarIdioma" class="disabled-link">
                      <img width="20" src="../../public/add.png" alt="">
                      Adicionar outro idioma.
                    </a>
                  </div>

                  <button type="submit" class="save btn btn-primary mt-3">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>


          <div v-if="currentSection === 'anexarCurriculo'">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Anexar Currículo</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="form-group">
                    <label for="curriculo">Por favor, escolha um arquivo de currículo para anexar. O formato deve ser
                      PDF ou DOCX.</label>
                    <div class="input-group mb-4">
                      <input type="file" class="form-control" id="inputGroupFile02">
                    </div>
                  </div>

                  <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";

export default {
  name: 'CurriculoCandidato',
  data() {
    return {
      currentSection: 'dadosPessoais',
      experiencias: [
        {
          empresa: '',
          cargo: '',
          empregoAtual: false,
          inicio: '',
          fim: '',
          descricao: ''
        }
      ],
      formacoes: [
        {
          formacao: '',
          grau: '',
          status: '',
          curso: '',
          instituicao: '',
          inicio: '',
          fim: ''
        }
      ],
      conquistasCertificados: [
        { tipo: '', titulo: '', descricao: '' }
      ],
      hardSkills: [],
      softSkills: [],
      newHardSkill: '',
      newSoftSkill: '',
      idiomas: [
        {
          nome: '',
          nivel: ''
        }
      ]
    };
  },
  methods: {
    showSection(section) {
      this.currentSection = section;
    },
    adicionarExperiencia() {
      this.experiencias.push({
        empresa: '',
        cargo: '',
        empregoAtual: false,
        inicio: '',
        fim: '',
        descricao: ''
      });
    },
    adicionarFormacao() {
      this.formacoes.push({
        formacao: '',
        grau: '',
        status: '',
        curso: '',
        instituicao: '',
        inicio: '',
        fim: ''
      });
    },
    adicionarConquistaCertificado() {
      this.conquistasCertificados.push({
        tipo: '',
        titulo: '',
        descricao: ''
      });
    },
    addHardSkill() {
      if (this.newHardSkill) {
        this.hardSkills.push(this.newHardSkill);
        this.newHardSkill = '';
      }
    },
    removeHardSkill(index) {
      this.hardSkills.splice(index, 1);
    },
    addSoftSkill() {
      if (this.newSoftSkill) {
        this.softSkills.push(this.newSoftSkill);
        this.newSoftSkill = '';
      }
    },
    removeSoftSkill(index) {
      this.softSkills.splice(index, 1);
    },
    adicionarIdioma() {
      this.idiomas.push({
        nome: '',
        nivel: ''
      });
    },
    salvarIdiomas() {
      console.log(this.idiomas);
    }
  },
  components: {
    Navbar,
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
  display: flex;
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
  margin-bottom: 30px;
}

.disabled-link {
  color: inherit;
  text-decoration: none;
}

.skill-badge {
  color: #504e4e;
  background-color: transparent;
  border: 1px solid 
  #cfcccc;
}

.upload {
  margin-bottom: 20px;
}
</style>
