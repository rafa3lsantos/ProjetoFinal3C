<template>
  <div>
    <Navbar />
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
      <div class="container p-3">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Meu Currículo</h5>
              </div>

              <div class="box-card">
                <div class="card-body">
                  <h6>Experiência Profissional</h6>
                  <ul>
                    <li v-if="experiences.length === 0">Nenhuma experiência encontrada.</li>
                    <li v-for="experience in experiences" :key="experience.id" class="mt-2">
                      <strong>{{ experience.job_title }}</strong> - {{ experience.company_name }}
                      <i class="fa-regular fa-pen-to-square edit-icon" @click="openModal(experience, 'experience')"></i>
                      <br />
                      <small>{{ experience.start_date }} até {{ experience.end_date || "Atualmente" }}</small> <br />
                      <p>{{ experience.description }}</p>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="box-card">
                <div class="card-body">
                  <h6>Formação</h6>
                  <ul>
                    <li v-if="formations.length === 0">Nenhuma formação encontrada.</li>
                    <li v-for="formation in formations" :key="formation.id" class="mt-2">
                      <strong>{{ formation.degree }}</strong> - {{ formation.institution }}
                      <i class="fa-regular fa-pen-to-square edit-icon" @click="openModal(formation, 'formation')"></i>
                      <br />
                      <small>{{ formation.start_date }} até {{ formation.end_date || "Atualmente" }}</small> <br />
                      <p>{{ formation.description }}</p>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="box-card">
                <div class="card-body">
                  <h6>Skills</h6>
                  <ul>
                    <li v-if="skills.length === 0">Nenhuma habilidade encontrada.</li>
                    <li v-for="skill in skills" :key="skill.id" class="mt-2">
                      <strong>Soft Skills:</strong> {{ skill.soft_skills.join(", ") }} <br />
                      <strong>Hard Skills:</strong> {{ skill.hard_skills.join(", ") }}
                      <i class="fa-regular fa-pen-to-square edit-icon" @click="openModal(skill, 'skill')"></i>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal fade show" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ modalTitle }}</h5>
            <button type="button" class="close" @click="closeModal">&times;</button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateData">
              <div v-if="modalType === 'skill'">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="soft_skills">Soft Skills</label>
                    <input type="text" class="form-control" v-model="selectedData.soft_skills"
                      placeholder="Ex: Comunicação, Trabalho em equipe">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="hard_skills">Hard Skills</label>
                    <input type="text" class="form-control" v-model="selectedData.hard_skills"
                      placeholder="Ex: JavaScript, PHP">
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
import HttpService from "../services/HttpService";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";
import axios from "axios";

export default {
  name: "CurriculoCandidato",
  components: {
    Navbar,
  },
  data() {
    return {
      usuario: {
        id: null,
        name: "",
        email: "",
        cep: "",
        address: "",
        state: "",
        city: "",
      },
      experiences: [],
      formations: [],
      skills: [],
      selectedData: null,
      token: localStorage.getItem("authToken") || "",
      showModal: false,
      modalTitle: "",
      modalType: "",
    };
  },
  created() {
    this.fetchUserProfile();
    this.fetchProfessionalExperiences();
    this.fetchFormations();
    this.fetchSkills();
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

    async fetchUserProfile() {
      try {
        const candidateId = this.usuario.id || localStorage.getItem("candidateId");
        const response = await HttpService.get(`/candidate/show/${candidateId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

        const user = response.data.candidate;
        this.usuario.name = user.name_candidate || "";
        this.usuario.email = user.email || "";
        this.usuario.cep = user.cep || "";
        this.usuario.address = user.address || "";
        this.usuario.state = user.state || "";
        this.usuario.city = user.city || "";
      } catch (error) {
        console.error("Erro ao carregar o perfil do usuário:", error);
      }
    },

    async fetchProfessionalExperiences() {
      try {
        const candidateId = localStorage.getItem("candidateId");
        if (!candidateId) {
          console.warn("ID do candidato não encontrado.");
          return;
        }

        const response = await HttpService.get(`/professional-experiences?candidateId=${candidateId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

        if (response.status === 200) {
          this.experiences = response.data.professionalExperiences || [];
        } else {
          console.warn("Nenhuma experiência profissional encontrada.");
        }
      } catch (error) {
        console.error("Erro ao buscar experiências profissionais:", error);
      }
    },

    async fetchFormations() {
      try {
        const candidateId = this.usuario.id;
        const response = await axios.get(`/formations/${candidateId}`, {
          headers: {
            'Authorization': `Bearer ${this.token}`,
          },
        });

        
        if (response.status === 200) {
          this.formations = response.data.formations || [];
        } else {
          console.warn("Nenhuma formação encontrada.");
        }
      } catch (error) {
        console.error("Erro ao buscar formações:", error);
      }
    },

    async fetchSkills() {
      try {
        const candidateId = this.usuario.id;
        const response = await axios.get(`/skills/show/${candidateId}`, {
          headers: {
            'Authorization': `Bearer ${this.token}`,
          },
        });

        if (response.status === 200) {
          this.skills = response.data.skills || [];
        } else {
          console.warn("Nenhuma habilidade encontrada.");
        }
      } catch (error) {
        console.error("Erro ao buscar habilidades:", error);
      }
    },

    openModal(data, type) {
      this.selectedData = { ...data };
      this.modalType = type;
      this.modalTitle = type === 'skill' ? 'Editar Habilidades' : 'Editar Informação';
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
      this.selectedData = null;
    },

    async updateData() {
      try {
        const url = this.modalType === 'skill'
          ? `/skills/update/${this.selectedData.id}`
          : `/formation/update/${this.selectedData.id}`;

        const response = await HttpService.put(url, this.selectedData, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

        if (response.status === 200) {
          this.showToast("success", "Dados atualizados com sucesso!");
          this.showModal = false;
          this.fetchSkills();
          this.fetchFormations();
        } else {
          this.showToast("error", "Erro ao atualizar os dados.");
        }
      } catch (error) {
        this.showToast("error", "Erro ao atualizar os dados.");
        console.error(error);
      }
    }
  }
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

.box-card {
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

.box-card ul {
  padding-left: 20px;
}

.box-card li {
  list-style-type: disc;
  margin-bottom: 10px;
}

.edit-icon {
  font-size: 16px;
  cursor: pointer;
  margin-left: 10px;
  color: #007bff;
  transition: color 0.3s;
}

.edit-icon:hover {
  color: #0056b3;
}


.modal-content {
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  border: none;
}

.modal-header {
  background-color: #007bff;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header .close {
  color: white;
  font-size: 1.5rem;
  opacity: 1;
  position: absolute;
  top: 10px;
  right: 20px;
}

.modal-header .close:hover {
  color: #0056b3;
}

.modal-body {
  padding: 30px;
  font-size: 1.1rem;
}

.modal-footer {
  border-top: 1px solid #e9ecef;
  padding: 20px;
  background-color: #f8f9fa;
}

button.close {
  border: none;
  background: none;
  font-size: 1.5rem;
}

button.save {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 1.1rem;
  transition: background-color 0.3s;
  border: none;
}

button.save:hover {
  background-color: #0056b3;
}

.modal-dialog {
  max-width: 800px;
  margin: 30px auto;
}

.modal-content {
  background-color: #ffffff;
}


@media (max-width: 768px) {
  .modal-content {
    border-radius: 5px;
  }

  .modal-header {
    font-size: 1rem;
    padding: 15px;
  }

  .modal-body {
    font-size: 1rem;
    padding: 20px;
  }

  .modal-footer {
    padding: 15px;
  }

  button.save {
    font-size: 1rem;
  }
}

.form-row {
  margin-top: 20px;
}

.form-group {
  margin-top: 20px;
  margin-bottom: 20px;
}

.espaço {
  margin-right: 20px;
}

.form-group .form-check {
  margin-left: 20px;
}
</style>
