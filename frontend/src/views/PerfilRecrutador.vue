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
                            <router-link to="/perfil-recrutador"
                                class="list-group-item list-group-item-action">Conta</router-link>
                            <router-link to="/add-vaga" class="list-group-item list-group-item-action">Adicionar
                                Vaga</router-link>

                            <router-link to="/minhas-vagas" class="list-group-item list-group-item-action">
                                Minhas Vagas
                            </router-link>
                            <router-link to="/minhas-vagas" class="list-group-item list-group-item-action">Minhas vagas</router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Conta</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateConta">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">Nome Completo</label>
                                            <input type="text" class="form-control" id="name"
                                                v-model="recruiter.recruiter_name" placeholder="Nome Completo">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                v-model="recruiter.email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label>Gênero</label>
                                            <div class="genero-options py-2">
                                                <div class="form-check" v-for="(option, index) in genderOptions"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" :name="'gender'"
                                                        :id="option.value" :value="option.value"
                                                        v-model="recruiter.gender">
                                                    <label class="form-check-label" :for="option.value">{{ option.label
                                                        }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Telefone</label>
                                            <input type="text" class="form-control" id="phone" v-model="recruiter.phone"
                                                placeholder="Informe seu Telefone" />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar Informações</button>
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
    components: {
        NavbarRecrutador
    },
    data() {
        return {
            recruiter: {
                id: '',
                recruiter_name: '',
                email: '',
                phone: '',
                gender: '',
            },
            genderOptions: [
                { label: 'Masculino', value: 'male' },
                { label: 'Feminino', value: 'female' },
                { label: 'Não-Binário', value: 'non-binary' },
                { label: 'Outro', value: 'other' },
                { label: 'Prefiro não responder', value: 'prefer not to say' },
            ],
            token: localStorage.getItem('authToken') || ''
        };
    },
    created() {
        this.fetchRecruiter();
    },
    computed: {
        ...mapGetters(['getRecruiterId'])
    },
    methods: {
        async sendUpdateRequest() {
            try {
                if (!this.token) {
                    alert('Usuário não autenticado!');
                    return;
                }

                const payload = {
                    recruiter_name: this.recruiter.recruiter_name,
                    email: this.recruiter.email,
                    phone: this.recruiter.phone,
                    gender: this.recruiter.gender,
                };

                const response = await HttpService.put(`/recruiter/update/${this.getRecruiterId}`, payload, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 200) {
                    alert('Informações da conta atualizadas com sucesso.');
                } else {
                    alert('Erro ao atualizar as informações do recrutador.');
                }
            } catch (error) {
                console.error("Erro ao atualizar conta:", error);
                alert('Erro ao atualizar informações da conta.');
            }
        },
        async updateConta() {
            await this.sendUpdateRequest();
        },
        async fetchRecruiter() {
            try {
                const recruiterId = this.getRecruiterId; 
                const response = await HttpService.get(`/recruiter/show/${recruiterId}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                });
                const recruiter = response.data.recruiter;
                this.recruiter.id = recruiterId;
                this.recruiter.recruiter_name = recruiter.recruiter_name || '';
                this.recruiter.phone = recruiter.recruiter_phone || '';
                this.recruiter.gender = recruiter.recruiter_gender || '';
                this.recruiter.email = recruiter.email || '';
            } catch (error) {
                console.error('Erro ao carregar o perfil do recrutador:', error);
            }
        }
    },
    mounted() {
        this.recruiter.id = this.getRecruiterId;
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
</style>
