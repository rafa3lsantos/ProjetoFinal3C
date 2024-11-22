<template>
    <div>
        <NavbarEmpresa />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil Empresa</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/perfil-empresa" class="list-group-item list-group-item-action">
                                Empresa
                            </router-link>
                            <router-link to="/add-recrutador" class="list-group-item list-group-item-action">
                                Adicionar Recrutador
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Adicionar Recrutador</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="registerRecruiter">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="recruiter_name">Nome do Recrutador</label>
                                            <input type="text" v-model="recruiter_name" class="form-control"
                                                placeholder="Nome completo do Recrutador" />
                                        </div>
                                        <div class="form-group">
                                            <label for="recruiter_birthdate">Data de Nascimento</label>
                                            <input type="date" v-model="recruiter_birthdate" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="recruiter_cpf">CPF</label>
                                            <input type="text" v-model="recruiter_cpf" class="form-control"
                                                placeholder="000.000.000-00" />
                                        </div>
                                        <div class="form-group">
                                            <label for="recruiter_phone">Telefone</label>
                                            <input type="text" v-model="recruiter_phone" class="form-control"
                                                placeholder="(XX) XXXXX-XXXX" />
                                        </div>
                                        <div class="form-group">
                                            <label>Gênero</label>
                                            <div class="genero-options py-2">
                                                <div class="form-check" v-for="(option, index) in genderOptions"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" :name="'gender'"
                                                        :id="option.value" :value="option.value"
                                                        v-model="recruiter_gender" />
                                                    <label class="form-check-label" :for="option.value">{{ option.label
                                                        }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" v-model="email" class="form-control"
                                                placeholder="exemplo@empresa.com" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Crie uma Senha</label>
                                            <input type="password" v-model="password" class="form-control"
                                                placeholder="Senha segura" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirme a senha</label>
                                            <input type="password" v-model="password_confirmation" class="form-control"
                                                placeholder="Repita a senha" />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Adicionar Recrutador</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarEmpresa from '@/components/NavbarEmpresa.vue';
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';

export default {
    components: {
        NavbarEmpresa,
    },
    data() {
        return {
            recruiter_name: '',
            recruiter_cpf: '',
            recruiter_phone: '',
            recruiter_gender: '',
            email: '',
            recruiter_birthdate: '',
            password: '',
            password_confirmation: '',
            genderOptions: [
                { label: 'Masculino', value: 'male' },
                { label: 'Feminino', value: 'female' },
                { label: 'Não-Binário', value: 'non-binary' },
                { label: 'Outro', value: 'other' },
                { label: 'Prefiro não responder', value: 'prefer not to say' },
            ],
        };
    },
    computed: {
        ...mapGetters(['getCompanyId']),
    },
    methods: {
        async registerRecruiter() {
            if (!this.recruiter_name || !this.recruiter_cpf || !this.email || !this.password || !this.recruiter_birthdate || !this.recruiter_phone) {
                alert('Preencha todos os campos obrigatórios!');
                return;
            }

            if (this.password !== this.password_confirmation) {
                alert('As senhas não coincidem!');
                return;
            }

            try {
                const token = localStorage.getItem('authToken');
                if (!token) {
                    alert('Usuário não autenticado!');
                    return;
                }

                const recruiterData = {
                    recruiter_name: this.recruiter_name,
                    recruiter_cpf: this.recruiter_cpf,
                    email: this.email,
                    recruiter_phone: this.recruiter_phone,
                    recruiter_gender: this.recruiter_gender,
                    recruiter_birthdate: this.recruiter_birthdate,
                    password: this.password,
                    company_id: this.getCompanyId,
                };

                const response = await HttpService.post('recruiter/register', recruiterData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.data.success) {
                    alert('Recrutador cadastrado com sucesso!');
                    this.$router.push('/perfil-empresa');
                } else {
                    alert('Erro ao cadastrar recrutador. Tente novamente!');
                }
            } catch (error) {
                console.error('Erro ao registrar recrutador:', error);
                alert('Erro no servidor. Tente novamente mais tarde!');
            }
        },
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
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.text-center img {
    margin-bottom: 15px;
}

.list-group-item-action {
    cursor: pointer;
}

.form-group {
    margin-bottom: 30px;
}

.genero-options {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
</style>
