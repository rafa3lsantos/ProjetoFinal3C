<template>
    <div>
        <Navbar />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/meu-perfil" class="list-group-item list-group-item-action">
                                Conta
                            </router-link>
                            <router-link to="/data-nascimento" class="list-group-item list-group-item-action">
                                Data de Nascimento
                            </router-link>
                            <router-link to="/email" class="list-group-item list-group-item-action">
                                Email
                            </router-link>
                            <router-link to="/senha" class="list-group-item list-group-item-action">
                                Senha
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data de Nascimento</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="salvarDataNascimento">
                                <div class="form-group">
                                    <label for="birthdate">Data de Nascimento</label>
                                    <input type="date" class="form-control" id="birthdate" v-model="usuario.birthdate">
                                    <small v-if="errors.birthdate" class="text-danger">{{ errors.birthdate }}</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar</button>
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
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            usuario: {
                id: "",
                birthdate: "",
            },
            errors: {},
            token: localStorage.getItem("authToken") || "",
        };
    },
    computed: {
        ...mapGetters(["getCandidateId"]),
    },
    methods: {
        validateFields() {
            this.errors = {};
            if (!this.usuario.birthdate) {
                this.errors.birthdate = "A data de nascimento é obrigatória.";
            }
            return Object.keys(this.errors).length === 0;
        },
        async salvarDataNascimento() {
            if (this.validateFields()) {
                try {
                    const response = await HttpService.put(
                        `/candidate/update/${this.getCandidateId}`,
                        {
                            birthdate: this.usuario.birthdate,
                        },
                        {
                            headers: {
                                Authorization: `Bearer ${this.token}`,
                                "Content-Type": "application/json",
                            },
                        }
                    );

                    if (response.status === 200) {
                        Toastify({
                            text: "Data de nascimento atualizada com sucesso.",
                            backgroundColor: "green",
                            position: "center",
                            duration: 3000,
                        }).showToast();
                    } else {
                        Toastify({
                            text: "Erro ao atualizar a data de nascimento.",
                            backgroundColor: "red",
                            position: "center",
                            duration: 3000,
                        }).showToast();
                    }
                } catch (error) {
                    console.error("Erro ao atualizar data de nascimento:", error);
                    Toastify({
                        text: "Erro ao salvar os dados.",
                        backgroundColor: "red",
                        position: "center",
                        duration: 3000,
                    }).showToast();
                }
            } else {
                Toastify({
                    text: "Por favor, preencha todos os campos obrigatórios.",
                    backgroundColor: "orange",
                    position: "center",
                    duration: 3000,
                }).showToast();
            }
        },
        async fetchUserProfile() {
            try {
                const response = await HttpService.get(
                    `/candidate/show/${this.getCandidateId}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );

                const user = response.data.candidate;
                this.usuario.id = user.id || "";
                this.usuario.birthdate = user.birthdate || "";
            } catch (error) {
                console.error("Erro ao carregar o perfil do usuário:", error);
                Toastify({
                    text: "Erro ao carregar o perfil.",
                    backgroundColor: "red",
                    position: "center",
                    duration: 3000,
                }).showToast();
            }
        },
    },
    mounted() {
        this.usuario.id = this.getCandidateId;
        this.fetchUserProfile();
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
