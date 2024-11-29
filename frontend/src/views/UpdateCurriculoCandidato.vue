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
                  <h6>Experiência Profissional <i class="fa-regular fa-pen-to-square edit-icon"></i></h6>
                  <ul>
                    <li v-for="experience in experiences" :key="experience.id" class="mt-2">
                      <strong>{{ experience.job_title }}</strong> - {{ experience.company_name }} <br />
                      <small>{{ experience.start_date }} até {{ experience.end_date || "Atualmente" }}</small> <br />
                      <p>{{ experience.description }}</p>
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Card Formação -->
              <div class="box-card">
                <div class="card-body">
                  <h6>Formação <i class="fa-regular fa-pen-to-square edit-icon"></i></h6>
                </div>
              </div>

              <!-- Card Skills -->
              <div class="box-card">
                <div class="card-body">
                  <h6>Skills <i class="fa-regular fa-pen-to-square edit-icon"></i></h6>
                </div>
              </div>

              <!-- Card Idioma -->
              <div class="box-card">
                <div class="card-body">
                  <h6>Idioma <i class="fa-regular fa-pen-to-square edit-icon"></i></h6>
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
import Navbar from "@/components/Navbar.vue";
import HttpService from "../services/HttpService";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

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
      token: localStorage.getItem("authToken") || "",
    };
  },
  created() {
    this.fetchUserProfile();
    this.fetchProfessionalExperiences();
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
        const response = await HttpService.get(`/professional-experiences`, {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        });

        if (response.status === 200) {
          this.experiences = response.data.professionalExperience || [];
        } else {
          console.warn("Nenhuma experiência profissional encontrada.");
        }
      } catch (error) {
        console.error("Erro ao buscar experiências profissionais:", error);
      }
    }

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
</style>
