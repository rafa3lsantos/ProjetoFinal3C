<template>
    <div>
        <NavbarRecrutador />

        <div class="container p-0">
            <div class="row">

                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/perfil-recrutador" class="list-group-item list-group-item-action">
                                Conta
                            </router-link>
                            <router-link to="/add-vaga" class="list-group-item list-group-item-action">
                                Adicionar Vaga
                            </router-link>
                            <router-link to="/minhas-vagas" class="list-group-item list-group-item-action">
                                Minhas Vagas
                            </router-link>

                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
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
                                                placeholder="Título da vaga que será exibido">
                                        </div>

                                        <div class="form-group">
                                            <label>Modelo de Trabalho</label>
                                            <div class="modelo-options py-2">
                                                <div class="form-check" v-for="(option, index) in modeloOptions"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" :id="`modelo-${index}`"
                                                        :value="option.value" v-model="vaga.work_model">
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
                                                    <input class="form-check-input" type="radio" :id="`tipo-${index}`"
                                                        :value="option.value" v-model="vaga.job_type">
                                                    <label class="form-check-label" :for="`tipo-${index}`">
                                                        {{ option.label }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="state">Estado</label>
                                            <input type="text" class="form-control" id="state" v-model="vaga.jobs_state"
                                                placeholder="Estado da vaga">
                                        </div>

                                        <div class="form-group">
                                            <label for="city">Cidade</label>
                                            <input type="text" class="form-control" id="city" v-model="vaga.jobs_city"
                                                placeholder="Cidade da vaga">
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Sobre a Vaga</label>
                                            <textarea rows="4" class="form-control" id="description"
                                                v-model="vaga.jobs_description"
                                                placeholder="Descrição detalhada da vaga, que o candidato gostaria de saber.">
                                            </textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Salvar Informações</button>
                                    </div>
                                </div>
                            </form>
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
            token: localStorage.getItem('authToken') || ''
        };
    },
    computed: {
        ...mapGetters(['getRecruiterId', 'getCompanyId'])
    },
    methods: {

        async fetchVaga() {
            try {
                const response = await HttpService.get(`/jobs/show/${this.$route.params.id}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 200) {
                    const vagaData = response.data.job;
                    this.vaga = {
                        ...this.vaga,
                        title: vagaData.title,
                        work_model: vagaData.work_model,
                        job_type: vagaData.job_type,
                        jobs_state: vagaData.jobs_state,
                        jobs_city: vagaData.jobs_city,
                        jobs_description: vagaData.jobs_description,
                        recruiter_id: vagaData.recruiter_id,
                        company_id: vagaData.company_id,
                    };
                } else {
                    alert('Erro ao carregar a vaga.');
                }
            } catch (error) {
                console.error('Erro ao carregar a vaga:', error);
            }
        },


        async updateVaga() {
            if (!this.validateFields()) return;

            this.vaga.recruiter_id = this.getRecruiterId;
            this.vaga.company_id = this.getCompanyId;

            try {
                const response = await HttpService.put(`/jobs/update/${this.$route.params.id}`, this.vaga, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 200) {
                    alert('Vaga atualizada com sucesso!');
                    this.$router.push('/minhas-vagas');
                } else {
                    alert('Erro ao atualizar a vaga. Tente novamente.');
                }
            } catch (error) {
                console.error('Erro ao atualizar a vaga:', error);
                alert('Erro ao atualizar a vaga.');
            }
        },

        validateFields() {
            if (!this.vaga.title || !this.vaga.work_model || !this.vaga.job_type || !this.vaga.jobs_state || !this.vaga.jobs_city || !this.vaga.jobs_description) {
                alert('Preencha todos os campos!');
                return false;
            }
            return true;
        },

        clearForm() {
            this.vaga = {
                title: '',
                work_model: '',
                job_type: '',
                jobs_state: '',
                jobs_city: '',
                jobs_description: ''
            };
        }
    },

    mounted() {
        this.fetchVaga();
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

.card-header {
    border-bottom-width: 1px;
    padding: .75rem 1.25rem;
    background-color: #fff;
    border-bottom: 1px solid #e5e9f2;
}

.form-control {
    width: 65%;
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
}

.form-check {
    margin-right: 15px;
}

.form-group {
    margin-bottom: 30px;
}
</style>
