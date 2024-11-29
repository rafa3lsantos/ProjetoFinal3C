<template>
  <div>
    <Navbar />

    <div class="container p-0">
      <div class="row">

        <div class="col-md-7 col-xl-8">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Meu Currículo</h5>
            </div>

            <div class="box-card">
              <div class="card-body">
                <h6>Dados Pessoais <i class="fas fa-edit edit-icon"></i></h6>
              </div>
            </div>

            <div class="box-card">
              <div class="card-body">
                <h6>Experiência Profissional <i class="fas fa-edit edit-icon"></i></h6>
              </div>
            </div>

            <div class="box-card">
              <div class="card-body">
                <h6>Formação <i class="fas fa-edit edit-icon"></i></h6>
              </div>
            </div>

            <div class="box-card">
              <div class="card-body">
                <h6>Skills <i class="fas fa-edit edit-icon"></i></h6>
              </div>
            </div>

            <div class="box-card">
              <div class="card-body">
                <h6>Idioma <i class="fas fa-edit edit-icon"></i></h6>
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
      token: localStorage.getItem("authToken") || "",
    };
  },
  created() {
    this.fetchUserProfile();
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

    async updateUsuario() {
      try {
        const id = this.usuario.id || localStorage.getItem("candidateId");

        const payload = {
          name_candidate: this.usuario.name,
          email: this.usuario.email,
          cep: this.usuario.cep,
          address: this.usuario.address,
          state: this.usuario.state,
          city: this.usuario.city,
        };

        const response = await HttpService.put(`/candidate/update/${id}`, payload, {
          headers: {
            Authorization: `Bearer ${this.token}`,
            "Content-Type": "application/json",
          },
        });

        if (response.status === 200) {
          this.showToast("success", "Currículo atualizado com sucesso!");
        } else {
          this.showToast("error", "Erro ao atualizar o currículo.");
        }
      } catch (error) {
        console.error("Erro ao atualizar o currículo:", error);
        this.showToast("error", "Erro ao atualizar o currículo.");
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
