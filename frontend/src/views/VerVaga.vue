<template>
    <div>
        <Navbar />
        <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
            <div class="container p-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div v-if="vaga">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">{{ vaga.title }}</h5>
                                            </div>

                                            <div class="first form-group">
                                                <span class="text-muted d-flex align-items-center">
                                                    <i class="fa fa-building" aria-hidden="true"></i>
                                                    <p class="mb-0 ml-2">{{ vaga.company_name }}</p>
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <span class="text-muted d-flex align-items-center">
                                                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                                                    <p class="mb-0 ml-2">{{ getTipoLabel(vaga.job_type) }}</p>
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <span class="text-muted d-flex align-items-center">
                                                    <i class="fa fa-map-pin" aria-hidden="true"></i>
                                                    <p class="mb-0 ml-2">{{ getModeloLabel(vaga.work_model) }}</p>
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <span class="text-muted d-flex align-items-center">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    <p class="mb-0 ml-2">{{ vaga.jobs_city }} - {{ vaga.jobs_state }}
                                                    </p>
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <div v-html="formattedDescription(vaga.jobs_description)"></div>
                                            </div>


                                        </div>
                                    </div>
                                    <button @click="goBack" class="btn btn-secondary w-20">Voltar</button>

                                    <button @click="candidatar"
                                        class="candidatar btn btn-primary w-40">Candidar-se</button>


                                </div>
                                <div v-else>
                                    <p>Carregando dados da vaga...</p>
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
import Navbar from '@/components/Navbar.vue';
import HttpService from '../services/HttpService';
import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

export default {
    components: { Navbar },
    data() {
        return {
            vaga: null,
            token: localStorage.getItem('authToken') || '',
        };
    },
    methods: {
        async fetchVaga() {
            try {
                if (!this.$route.params.id) {
                    Toastify({
                        text: 'ID da vaga não encontrado!',
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#f44336",
                    }).showToast();
                    return;
                }

                const response = await HttpService.get(`/jobs/show/${this.$route.params.id}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200 && response.data.jobs) {
                    this.vaga = response.data.jobs;
                    Toastify({
                        text: 'Vaga carregada com sucesso!',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#4caf50",
                    }).showToast();
                } else {
                    Toastify({
                        text: 'Erro ao carregar a vaga. Verifique a resposta da API.',
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#f44336",
                    }).showToast();
                }
            } catch (error) {
                console.error('Erro ao carregar a vaga:', error);
                Toastify({
                    text: 'Erro ao carregar a vaga. Tente novamente.',
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#f44336",
                }).showToast();
            }
        },

        async candidatar() {
            try {
                if (!this.vaga?.id) {
                    Toastify({
                        text: 'ID da vaga não está disponível.',
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#f44336",
                    }).showToast();
                    return;
                }

                const response = await HttpService.post('/applications/applyToJob', {
                    job_id: this.vaga.id
                }, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 201) {
                    Toastify({
                        text: response.data.message || 'Candidatura realizada com sucesso!',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#4caf50",
                    }).showToast();
                }
            } catch (error) {
                console.error('Erro ao candidatar-se:', error);
                Toastify({
                    text: 'Erro ao se candidatar. Tente novamente.',
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#f44336",
                }).showToast();
            }
        },

        getModeloLabel(work_model) {
            const models = {
                presential: 'Presencial',
                remote: 'Remoto',
                hybrid: 'Híbrido',
            };
            return models[work_model] || 'Não especificado';
        },
        getTipoLabel(job_type) {
            const types = {
                effective: 'Efetivo',
                freelancer: 'Freelancer',
                temporary: 'Temporário',
                internship: 'Estágio',
            };
            return types[job_type] || 'Não especificado';
        },
        goBack() {
            this.$router.push('/vagas');
        },
        formattedDescription(description) {
            return description ? description.replace(/\n/g, "<br>") : '';
        },
    },
    mounted() {
        this.fetchVaga();
    },
};
</script>

<style scoped>
body {
    background: #F0F8FF;
}

.card {
    box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08);
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid #e5e9f2;
    background-color: #fff;
    padding: 1rem;
}

.card-body {
    font-size: 1.1rem;
}

.form-group {
    margin-bottom: 20px;
}

button {
    margin-top: 20px;
}

@media (max-width: 576px) {
    .card {
        padding: 1rem;
    }

    .btn-primary {
        font-size: 0.9rem;
    }

    .form-group label {
        font-size: 0.9rem;
    }
}

.tittle {
    font-size: 30px;
}

.first {
    margin-top: 25px;
}

i {
    margin-right: 5px;
}

.candidatar {
    margin-left: 20px;
}
</style>
