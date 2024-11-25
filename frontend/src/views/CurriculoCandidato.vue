<template>
  <div>
    <Navbar />

    <div class="container p-0">
      <div class="row">
        <div class="col-md-5 col-xl-4">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Currículo</h5>
            </div>
            <div class="list-group list-group-flush" role="tablist">
              <router-link to="/curriculo" class="list-group-item list-group-item-action">Dados Pessoais</router-link>
              <router-link to="/experiencia-profissional" class="list-group-item list-group-item-action">Experiência
                Profissional</router-link>
              <router-link to="/formacao" class="list-group-item list-group-item-action">Formação</router-link>
              <router-link to="/conquistas-certificados"
                class="list-group-item list-group-item-action">Certificados</router-link>
              <router-link to="/skills" class="list-group-item list-group-item-action">Skills</router-link>
              <router-link to="/idiomas" class="list-group-item list-group-item-action">Idiomas</router-link>
            </div>
          </div>
        </div>

        <div class="col-md-7 col-xl-8">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Dados Pessoais</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="updateCurriculum">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="nomeCandidato">Nome Completo</label>
                    <input type="text" class="form-control" id="nomeCandidato" v-model="curriculum.name"
                      placeholder="Digite seu nome">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="emailCandidato">Email</label>
                  <input type="email" class="form-control" id="emailCandidato" v-model="curriculum.email"
                    placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                  <label for="cepCandidato">CEP</label>
                  <input type="text" class="form-control" id="cepCandidato" v-model="curriculum.cep"
                    placeholder="Digite seu CEP">
                </div>
                <div class="form-group col-md-6">
                  <label for="enderecoCandidato">Endereço</label>
                  <input type="text" class="form-control" id="enderecoCandidato" v-model="curriculum.address"
                    placeholder="Digite seu endereço">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="estadoCandidato">Estado</label>
                    <input type="text" class="form-control" id="estadoCandidato" v-model="curriculum.state"
                      placeholder="Digite seu estado">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cidadeCandidato">Cidade</label>
                    <input type="text" class="form-control" id="cidadeCandidato" v-model="curriculum.city"
                      placeholder="Digite sua cidade">
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
</template>

<script>
import Navbar from "@/components/Navbar.vue";
import HttpService from "../services/HttpService";

export default {
  name: "CurriculoCandidato",
  components: {
    Navbar,
  },
  data() {
    return {
      curriculum: {
        id: null,
        name: "",
        email: "",
        cep: "",
        address: "",
        state: "",
        city: "",
      },
      token: localStorage.getItem("authToken") || "",
    };
  },
  created() {
    this.fetchCurriculum();
  },
  methods: {
    async fetchCurriculum() {
      try {
        const userId = localStorage.getItem("candidateId");
        const response = await HttpService.get(`/curriculum/show/${CandidateId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });
        this.curriculum = response.data;
      } catch (error) {
        console.error("Erro ao buscar currículo:", error);
        alert("Erro ao buscar os dados do currículo.");
      }
    },
    async updateCurriculum() {
      try {
        const payload = { ...this.curriculum };
        const response = await HttpService.post(`/curriculum/register`, payload, {
          headers: {
            Authorization: `Bearer ${this.token}`,
            "Content-Type": "application/json",
          },
        });
        if (response.status === 200) {
          alert("Currículo atualizado com sucesso!");
        } else {
          alert("Erro ao atualizar o currículo.");
        }
      } catch (error) {
        console.error("Erro ao atualizar o currículo:", error);
        alert("Erro ao atualizar o currículo.");
      }
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
  border: 1px solid #cfcccc;
}

.upload {
  margin-bottom: 20px;
}
</style>
