<template>
    <div>
        <section class="vh-100" style="background-color: #cfcccc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Formação Acadêmica:
                                    </h5>
                                    <form @submit.prevent="openModal">
                                        <div v-for="(formacao, index) in formacoes" :key="index">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="institution">Instituição</label>
                                                    <input type="text" class="form-control"
                                                        v-model="formacao.institution" required>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="formation">Formação</label>
                                                    <select class="form-control" v-model="formacao.formation" required>
                                                        <option value="graduação">Graduação</option>
                                                        <option value="pos-graduação">Pós-graduação</option>
                                                        <option value="mestrado">Mestrado</option>
                                                        <option value="doutorado">Doutorado</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="degree">Grau</label>
                                                    <select class="form-control" v-model="formacao.degree" required>
                                                        <option value="tecnologo">Tecnólogo</option>
                                                        <option value="licenciatura">Licenciatura</option>
                                                        <option value="bacharelado">Bacharelado</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="course">Curso</label>
                                                    <input type="text" class="form-control" v-model="formacao.course"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="start_date_course">Início do curso</label>
                                                    <input type="date" class="form-control"
                                                        v-model="formacao.start_date_course" required>
                                                </div>
                                                <div class="form-group col-md-6" v-if="!formacao.status">
                                                    <label for="end_date_course">Fim do curso (se aplicável)</label>
                                                    <input type="date" class="form-control"
                                                        v-model="formacao.end_date_course">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" v-model="formacao.status" required>
                                                        <option value="completo">Completo</option>
                                                        <option value="em andamento">Em andamento</option>
                                                        <option value="incompleto">Incompleto</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="save btn btn-primary">Salvar Formação</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja adicionar mais formações?</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você deseja adicionar mais formações ou prosseguir?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="addAnotherFormation">Adicionar mais
                            formação</button>
                        <button type="button" class="btn btn-primary" @click="proceed">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>




<script>
import HttpService from '../services/HttpService';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { mapGetters } from 'vuex'; 

export default {
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
        openModal() {
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        async addAnotherFormation() {
            try {
                if (this.formacoes.length === 0) {
                    this.showToast('error', 'Nenhuma formação encontrada para enviar.');
                    return;
                }

                const formacao = this.formacoes[0];

                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                formacao.candidate_id = this.getCandidateId;

                console.log('Dados da formação a serem enviados:', {
                    formation: formacao.formation,
                    institution: formacao.institution,
                    degree: formacao.degree,
                    course: formacao.course,
                    start_date_course: formacao.start_date_course,
                    end_date_course: formacao.end_date_course,
                    status: formacao.status,
                    candidate_id: formacao.candidate_id,
                });

                const response = await HttpService.post('/formation/register', {
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

                if (response.status === 201) {
                    this.showToast('success', 'Formação registrada com sucesso.');

                    this.formacoes = [{
                        formation: '',
                        institution: '',
                        degree: '',
                        course: '',
                        start_date_course: '',
                        end_date_course: '',
                        status: '',
                        candidate_id: ''
                    }];
                    this.closeModal();
                } else {
                    this.showToast('error', 'Erro ao registrar formação.');
                }
            } catch (error) {
                console.error('Erro ao registrar formação:', error);
                this.showToast('error', 'Erro ao registrar formação.');
            }
        },

        async proceed() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const formacao = this.formacoes[0];

                formacao.candidate_id = this.getCandidateId;

                const response = await HttpService.post('/formation/register', {
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

                if (response.status === 201) {
                    this.showToast('success', 'Formação registrada com sucesso.');
                    this.$router.push('/skills');
                } else {
                    this.showToast('error', 'Erro ao registrar formação.');
                }
            } catch (error) {
                this.showToast('error', 'Erro ao registrar formação.');
            }
        },

        showToast(type, message) {
            let backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            Toastify({
                text: message,
                duration: 1000,
                close: true,
                gravity: 'top',
                position: 'right',
                backgroundColor: backgroundColor,
            }).showToast();
        }
    }
};
</script>




<style scoped>
body {
    margin-top: 20px;
    background-color: #cfcccc;
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

.genero-options {
    display: flex;
    flex-wrap: wrap;
}

.form-check {
    margin-right: 15px;
}

.form-group {
    margin-bottom: 30px;
}

.text-center small {
    display: block;
}

.nota {
    font-size: 12px;
    font-style: italic;
}
</style>
