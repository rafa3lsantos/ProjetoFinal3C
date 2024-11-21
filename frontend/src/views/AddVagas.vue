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
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Adicionar Vaga</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="createJob">
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
                                                v-model="vaga.description"
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
                description: '',
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
    methods: {
        async createJob() {
            if (!this.validateFields()) return;

            try {
                const response = await HttpService.post('/jobs/register', this.vaga, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 201) {
                    alert('Vaga criada com sucesso!');
                    this.clearForm();
                } else {
                    alert('Erro ao criar a vaga. Tente novamente.');
                }
            } catch (error) {
                console.error('Erro ao criar vaga:', error);
                alert('Erro ao criar a vaga.');
            }
        },
        validateFields() {
            if (!this.vaga.title || !this.vaga.work_model || !this.vaga.job_type || !this.vaga.jobs_state || !this.vaga.jobs_city || !this.vaga.description) {
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
                description: ''
            };
        }
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
