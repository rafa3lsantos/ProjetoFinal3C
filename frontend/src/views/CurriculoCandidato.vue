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
              <router-link to="/curriculo" class="list-group-item list-group-item-action">Experiência Profissional</router-link>
              <router-link to="/update-formacao" class="list-group-item list-group-item-action">Formação</router-link>
              <router-link to="/update-idiomas" class="list-group-item list-group-item-action">Idiomas</router-link>
            </div>
          </div>
        </div>

        <div class="col-md-7 col-xl-8">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Experiência Profissional</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="updateExperience">
                <div v-for="(experiencia, index) in experiencias" :key="index">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="company">Empresa</label>
                      <input type="text" class="form-control" id="company" v-model="experiencia.company"
                        placeholder="Digite o nome da empresa" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="position">Cargo</label>
                        <input type="text" class="form-control" id="position" v-model="experiencia.position"
                          placeholder="Cargo que exercia" required>
                      </div>
                    </div>
                    <div>
                      <label>Meu emprego Atual</label>
                      <div class="genero-options py-2">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" v-model="experiencia.isCurrentlyWorking">
                          <label class="form-check-label">Emprego Atual</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="start_date_work">Início</label>
                      <input type="date" class="form-control" v-model="experiencia.startDateWork" id="start_date_work"
                        required>
                    </div>
                  </div>
                  <div v-if="!experiencia.isCurrentlyWorking" class="form-row">
                    <div class="form-group col-md-6">
                      <label for="end_date_work">Fim</label>
                      <input type="date" class="form-control" v-model="experiencia.endDateWork" id="end_date_work">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="description_activities">Descrição das atividades</label>
                      <textarea class="form-control" id="description_activities"
                        v-model="experiencia.descriptionActivities" rows="4" placeholder="Descreva as atividades..."
                        required></textarea>
                    </div>
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
import { mapGetters } from "vuex";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

export default {
  name: "CurriculoCandidato",
  components: {
    Navbar,
  },
  data() {
    return {
      experiencias: [{
        company: '',
        position: '',
        isCurrentlyWorking: false,
        startDateWork: '',
        endDateWork: '',
        descriptionActivities: ''
      }],
      token: localStorage.getItem("authToken") || "",
    };
  },
  computed: {
    ...mapGetters(["getCandidateId"]),
  },
  methods: {
    showToast(type, message) {
      let backgroundColor = type === "success" ? "#28a745" : "#dc3545";
      Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "center",
        backgroundColor: backgroundColor,
        color: "white",
        close: true,
      }).showToast();
    },

    validateExperience(experiencia) {
      // Validação para garantir que todos os campos obrigatórios estão preenchidos
      if (!experiencia.company || !experiencia.position || !experiencia.startDateWork || !experiencia.descriptionActivities) {
        this.showToast('error', 'Todos os campos são obrigatórios!');
        return false;
      }
      return true;
    },

    async updateExperience() {
      try {
        if (!this.token) {
          this.showToast('error', 'Usuário não autenticado!');
          return;
        }

        const candidateId = this.getCandidateId;
        if (!candidateId) {
          this.showToast('error', 'ID do candidato não encontrado.');
          return;
        }

        const experiencia = this.experiencias[0];  // Verifique se está tratando corretamente o índice

        // Validação de dados
        if (!this.validateExperience(experiencia)) return;

        const experienceData = {
          company: experiencia.company,
          position: experiencia.position,
          is_currently_working: experiencia.isCurrentlyWorking,
          start_date_work: experiencia.startDateWork,
          end_date_work: experiencia.isCurrentlyWorking ? null : experiencia.endDateWork,
          description_activities: experiencia.descriptionActivities,
        };

        console.log('Dados enviados:', experienceData);  // Adicionando console para depuração

        const response = await HttpService.put(`/candidate/update/${candidateId}`, experienceData, {
          headers: {
            'Authorization': `Bearer ${this.token}`,
            'Content-Type': 'application/json',
          },
        });

        if (response.status === 200) {
          this.showToast('success', 'Experiência profissional atualizada com sucesso.');
        } else {
          this.showToast('error', 'Erro ao atualizar experiência profissional.');
        }
      } catch (error) {
        console.log(error);
        this.showToast('error', 'Erro ao atualizar experiência profissional.');
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

.card-header {
  border-bottom-width: 1px;
  padding: .75rem 1.25rem;
  background-color: #fff;
  border-bottom: 1px solid #e5e9f2;
}

.save {
  margin-top: 20px;
}

.form-group {
  margin-bottom: 30px;
}

.form-check {
  margin-right: 15px;
}

.text-center small {
  display: block;
}
</style>
