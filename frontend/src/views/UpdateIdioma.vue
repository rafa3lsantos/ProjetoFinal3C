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
                            <router-link to="/curriculo" class="list-group-item list-group-item-action">
                                Dados Pessoais
                            </router-link>
                            <router-link to="/experiencia-profissional" class="list-group-item list-group-item-action">
                                Experiência Profissional
                            </router-link>
                            <router-link to="/formacao" class="list-group-item list-group-item-action">
                                Formação
                            </router-link>
                            <router-link to="/certificados" class="list-group-item list-group-item-action">
                                Certificados
                            </router-link>
                            <router-link to="/skills" class="list-group-item list-group-item-action">
                                Skills
                            </router-link>
                            <router-link to="/idiomas" class="list-group-item list-group-item-action">
                                Idiomas
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card" v-if="currentSection === 'idiomas'">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Idiomas</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateIdioma">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label for="idioma">Idioma</label>
                                        <input type="text" class="form-control" id="idioma" v-model="idioma.language"
                                            placeholder="Digite o idioma" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nivel">Nível</label>
                                        <select id="nivel" class="form-control" v-model="idioma.level" required>
                                            <option value="" disabled>Selecione o nível</option>
                                            <option value="beginner">Iniciante</option>
                                            <option value="intermediate">Intermediário</option>
                                            <option value="advanced">Avançado</option>
                                            <option value="fluent">Fluente</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Salvar Informações
                                </button>
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
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { mapGetters } from "vuex";

export default {
    name: "Idiomas",
    components: {
        Navbar,
    },
    data() {
        return {
            idioma: {
                language: "",
                level: "",
            },
            currentSection: 'idiomas',
            token: localStorage.getItem('authToken') || '',
        };
    },
    computed: {
        ...mapGetters(["getCandidateId"]),
    },
    methods: {
        async updateIdioma() {
            try {
                if (!this.token) {
                    alert("Usuário não autenticado!");
                    return;
                }


                this.idioma.candidate_id

                const response = await HttpService.put(`/candidate/update/${this.getCandidateId}`, {
                    language: this.idioma.language,
                    level: this.idioma.level,
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200) {
                    this.showToast('success', 'Formação atualizada com sucesso.');
                } else {
                    this.showToast('error', 'Erro ao atualizar formação.');
                }

            } catch (error) {
                console.error(error);
                this.showToast('error', 'Erro ao atualizar formação.');
            }
        },
        showToast(type, message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: 'top',
                position: 'center',
                backgroundColor: type === 'success' ? '#4fbe79' : '#d9534f',
            }).showToast();
        },
    },
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

.card-header {
    border-bottom-width: 1px;
    padding: .75rem 1.25rem;
    background-color: #fff;
    border-bottom: 1px solid #e5e9f2;
}

.form-group {
    margin-bottom: 30px;
}

.btn {
    margin-top: 20px;
}
</style>
