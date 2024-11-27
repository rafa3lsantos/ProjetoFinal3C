<template>
    <div>
        <NavbarRecrutador />
        <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
            <div class="container p-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Editar Vaga</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="updateVaga">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Título da Vaga</label>
                                                <input type="text" class="form-control" id="title" v-model="vaga.title"
                                                    placeholder="Título da vaga que será exibido" />
                                            </div>

                                            <div class="form-group">
                                                <label>Modelo de Trabalho</label>
                                                <div class="modelo-options py-2">
                                                    <div class="form-check" v-for="(option, index) in modeloOptions"
                                                        :key="index">
                                                        <input class="form-check-input" type="radio"
                                                            :id="`modelo-${index}`" :value="option.value"
                                                            v-model="vaga.work_model" />
                                                        <label class="form-check-label" :for="`modelo-${index}`">
                                                            {{ option.label }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Tipo de Trabalho</label>
                                                <div class="tipo-options py-2">
                                                    <div class="form-check" v-for="(option, index) in tipoOptions"
                                                        :key="index">
                                                        <input class="form-check-input" type="radio"
                                                            :id="`tipo-${index}`" :value="option.value"
                                                            v-model="vaga.job_type" />
                                                        <label class="form-check-label" :for="`tipo-${index}`">
                                                            {{ option.label }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="state">Estado</label>
                                                <input type="text" class="form-control" id="state"
                                                    v-model="vaga.jobs_state" placeholder="Estado da vaga" />
                                            </div>

                                            <div class="form-group">
                                                <label for="city">Cidade</label>
                                                <input type="text" class="form-control" id="city"
                                                    v-model="vaga.jobs_city" placeholder="Cidade da vaga" />
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status da Vaga</label>
                                                <select class="form-control" id="status" v-model="vaga.jobs_status">
                                                    <option v-for="(status, index) in statusOptions" :key="index"
                                                        :value="status.value">
                                                        {{ status.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="about_candidate">Sobre você</label>
                                                    <textarea rows="6" class="form-control" id="about_candidate"
                                                        v-model="vaga.jobs_description"
                                                        placeholder="Faça um breve resumo sobre você"></textarea>
                                                </div>
                                            </div>

                                            <button @click="goBack" class="btn btn-secondary w-20">Voltar</button>
                                            <button type="submit" class="salvar btn btn-primary w-20">Salvar
                                                Informações</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import NavbarRecrutador from '@/components/NavbarRecrutador.vue';
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';

export default {
    components: { NavbarRecrutador },
    data() {
        return {
            vaga: {
                title: '',
                work_model: '',
                job_type: '',
                jobs_state: '',
                jobs_city: '',
                jobs_description: '',
                jobs_status: '',
                recruiter_id: '',
                company_id: '',
            },
            modeloOptions: [
                { label: 'Presencial', value: 'presential' },
                { label: 'Remoto', value: 'remote' },
                { label: 'Híbrido', value: 'hybrid' },
            ],
            tipoOptions: [
                { label: 'Efetivo', value: 'effective' },
                { label: 'Freelancer', value: 'freelancer' },
                { label: 'Temporário', value: 'temporary' },
                { label: 'Estágio', value: 'internship' },
            ],
            statusOptions: [
                { label: 'Em andamento', value: 'in_progress' },
                { label: 'Em análise', value: 'under_review' },
                { label: 'Finalizada', value: 'finished' },
            ],
            token: localStorage.getItem('authToken') || '',
        };
    },
    computed: {
        ...mapGetters(['getRecruiterId', 'getCompanyId']),
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
        async updateVaga() {
            console.log('Dados enviados:', this.vaga);
            if (!this.validateFields()) return;

            this.vaga.recruiter_id = this.getRecruiterId;
            this.vaga.company_id = this.getCompanyId;

            try {
                const response = await HttpService.put(`/jobs/update/${this.$route.params.id}`, this.vaga, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                console.log('Resposta da API:', response);
                if (response.status === 200) {
                    alert('Vaga atualizada com sucesso!');
                    this.$router.push('/minhas-vagas');
                } else {
                    alert('Erro ao atualizar a vaga. Tente novamente.');
                }
            } catch (error) {
                console.error('Erro ao atualizar a vaga:', error.response);
                alert('Erro ao atualizar a vaga.');
            }
        },


        validateFields() {
            if (!this.vaga.title || !this.vaga.work_model || !this.vaga.job_type || !this.vaga.jobs_state || !this.vaga.jobs_city || !this.vaga.jobs_description || !this.vaga.jobs_status) {
                alert('Preencha todos os campos!');
                return false;
            }
            return true;
        },
        goBack() {
            this.$router.push('/minhas-vagas');
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

.form-control {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

textarea.form-control {
    resize: none;
}

.modelo-options,
.tipo-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
}

.salvar {
    margin-left: 20px;
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
</style>
