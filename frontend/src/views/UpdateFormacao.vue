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
                            <router-link to="/curriculo" class="list-group-item list-group-item-action">Experiência
                                Profissional</router-link>
                            <router-link to="/formacao"
                                class="list-group-item list-group-item-action">Formação</router-link>
                            <router-link to="/update-idiomas"
                                class="list-group-item list-group-item-action">Idiomas</router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Formação</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateFormation">
                                <div v-for="(formacao, index) in formacoes" :key="index">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="instituicao{{ index }}">Instituição</label>
                                            <input type="text" class="form-control" :id="'instituicao' + index"
                                                v-model="formacao.institution" placeholder="Nome da Instituição"
                                                required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="formacao{{ index }}">Formação</label>
                                            <select class="form-control" v-model="formacao.formation" required>
                                                <option value="graduação">Graduação</option>
                                                <option value="pos-graduação">Pós-graduação</option>
                                                <option value="mestrado">Mestrado</option>
                                                <option value="doutorado">Doutorado</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="grau{{ index }}">Grau</label>
                                            <select class="form-control" v-model="formacao.degree" required>
                                                <option value="tecnologo">Tecnólogo</option>
                                                <option value="licenciatura">Licenciatura</option>
                                                <option value="bacharelado">Bacharelado</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="curso{{ index }}">Curso</label>
                                            <input type="text" class="form-control" :id="'curso' + index"
                                                v-model="formacao.course" placeholder="Nome do Curso" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inicio{{ index }}">Início do curso</label>
                                            <input type="date" class="form-control" :id="'inicio' + index"
                                                v-model="formacao.start_date_course" required>
                                        </div>

                                        <div class="form-group col-md-6" v-if="!formacao.status">
                                            <label for="fim{{ index }}">Fim do curso (se aplicável)</label>
                                            <input type="date" class="form-control" :id="'fim' + index"
                                                v-model="formacao.end_date_course">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="status{{ index }}">Status</label>
                                            <select class="form-control" v-model="formacao.status" required>
                                                <option value="completo">Completo</option>
                                                <option value="em andamento">Em andamento</option>
                                                <option value="incompleto">Incompleto</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Salvar Formação</button>
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
import HttpService from '../services/HttpService';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { mapGetters } from 'vuex';

export default {
    name: 'Formacao',
    components: {
        Navbar,
    },
    data() {
        return {
            formacoes: [{
                formation: '',
                institution: '',
                degree: '',
                course: '',
                start_date_course: '',
                end_date_course: '',
                status: '',
                candidate_id: ''
            }],
            token: localStorage.getItem('authToken') || '',
            showModal: false,
        };
    },
    computed: {
        ...mapGetters(['getCandidateId'])
    },
    methods: {
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

        async updateFormation() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const formacao = this.formacoes[0];
                formacao.candidate_id = this.getCandidateId;

                const response = await HttpService.put(`/candidate/update/${this.getCandidateId}`, {
                    formation: formacao.formation,
                    institution: formacao.institution,
                    degree: formacao.degree,
                    course: formacao.course,
                    start_date_course: formacao.start_date_course,
                    end_date_course: formacao.end_date_course,
                    status: formacao.status,
                    candidate_id: formacao.candidate_id,
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

.card-header {
    border-bottom-width: 1px;
    padding: .75rem 1.25rem;
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