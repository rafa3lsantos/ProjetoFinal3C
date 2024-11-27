<template>
    <div>
        <Navbar />
        <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
            <div class="container p-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Detalhes da Vaga</h5>
                            </div>
                            <div class="card-body">
                                <div v-if="vaga">
                                    <div class="row">
                                        <div class="col-12">
                                            
                                            <div class="form-group">
                                                <p class="tittle">{{ vaga.title }}</p>
                                            </div>

                                            <div class="form-group">
                                                <p>{{ getModeloLabel(vaga.work_model)}}</p>
                                            </div>

                                            <div class="form-group">
                                                <label>Tipo de Trabalho</label>
                                                <p>{{ getTipoLabel(vaga.job_type) }}</p>
                                            </div>

                                            <div class="form-group">
                                                <label for="state">Estado</label>
                                                <p>{{ vaga.jobs_state }}</p>
                                            </div>

                                            <div class="form-group">
                                                <label for="city">Cidade</label>
                                                <p>{{ vaga.jobs_city }}</p>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Sobre a Vaga</label>
                                                <p>{{ vaga.jobs_description }}</p>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status da Vaga</label>
                                                <p>{{ getStatusLabel(vaga.jobs_status) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button @click="goBack" class="btn btn-secondary w-20">Voltar</button>
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
                    alert('ID da vaga não encontrado!');
                    return;
                }

                const response = await HttpService.get(`/jobs/show/${this.$route.params.id}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });


                if (response.status === 200 && response.data.jobs) {
                    const vagaData = response.data.jobs;
                    this.vaga = {
                        ...this.vaga,
                        title: vagaData.title || '',
                        work_model: vagaData.work_model || '',
                        job_type: vagaData.job_type || '',
                        jobs_state: vagaData.jobs_state || '',
                        jobs_city: vagaData.jobs_city || '',
                        jobs_description: vagaData.jobs_description || '',
                        jobs_status: vagaData.jobs_status || '',
                        recruiter_id: vagaData.recruiter_id || '',
                        company_id: vagaData.company_id || '',
                    };
                } else {
                    alert('Erro ao carregar a vaga. Verifique a resposta da API.');
                }
            } catch (error) {
                console.error('Erro ao carregar a vaga:', error);
                alert('Erro ao carregar a vaga. Tente novamente.');
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
        getStatusLabel(jobs_status) {
            const statuses = {
                in_progress: 'Em andamento',
                under_review: 'Em análise',
                finished: 'Finalizada',
            };
            return statuses[jobs_status] || 'Não especificado';
        },
        goBack() {
            this.$router.push('/vagas');
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
</style>
