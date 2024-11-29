<template>
    <div>
        <section class="vh-100" style="background-color: #cfcccc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Dados Pessoais:</h5>
                                    <form @submit.prevent="updateConta">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Gênero</label>
                                                    <div class="genero-options py-2">
                                                        <div class="form-check" v-for="(option, index) in genderOptions"
                                                            :key="index">
                                                            <input class="form-check-input" type="radio"
                                                                :name="'gender'" :id="option.value"
                                                                :value="option.value" v-model="usuario.gender">
                                                            <label class="form-check-label" :for="option.value">{{
                                                                option.label }}</label>
                                                        </div>
                                                    </div>
                                                    <span v-if="errors.gender" class="text-danger">{{ errors.gender
                                                        }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="about_candidate">Sobre você</label>
                                                    <textarea rows="2" class="form-control" id="about_candidate"
                                                        v-model="usuario.about_candidate"
                                                        placeholder="Faça um breve resumo sobre você"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Telefone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        v-model="usuario.phone" placeholder="Informe seu Telefone"
                                                        @input="formatPhone" maxlength="15" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
export default {
    data() {
        return {
            usuario: {
                id: '',
                name_candidate: '',
                about_candidate: '',
                phone: '',
                gender: '',
            },
            genderOptions: [
                { label: 'Masculino', value: 'masculino' },
                { label: 'Feminino', value: 'feminino' },
                { label: 'Não-Binário', value: 'nao-binario' },
                { label: 'Outro', value: 'outro' },
                { label: 'Prefiro não responder', value: 'sem-resposta' }
            ],
            errors: {},
            token: localStorage.getItem('authToken') || '',
        };
    },
    created() {
        this.fetchUserProfile();
    },
    computed: {
        ...mapGetters(['getCandidateId'])
    },
    methods: {
        showToast(type, message) {
            let backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            Toastify({
                text: message,
                duration: 3000,
                gravity: 'top',
                position: 'center',
                backgroundColor: backgroundColor,
                color: 'white',
                close: true,
                offset: { x: 50, y: 50 },
            }).showToast();
        },

        validateFields() {
            this.errors = {};
            if (!this.usuario.name_candidate) {
                this.errors.name_candidate = "O nome é obrigatório.";
            }
            if (!this.usuario.gender) {
                this.errors.gender = "O gênero é obrigatório.";
            }
            return Object.keys(this.errors).length === 0;
        },

        async sendUpdateRequest() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const updateResponse = await HttpService.put(
                    `/candidate/update/${this.getCandidateId}`,
                    this.usuario,
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }
                );

                if (updateResponse.status !== 200) {
                    this.showToast('error', 'Erro ao atualizar as informações do candidato.');
                    return;
                }

                this.showToast('success', 'Informações da conta atualizadas com sucesso.');
                this.$router.push('/experiencia-profissional');
            } catch (error) {
                console.error("Erro ao atualizar conta:", error);
                this.showToast('error', 'Erro ao atualizar informações da conta.');
            }
        },

        async updateConta() {
            if (this.validateFields()) {
                await this.sendUpdateRequest();
            }
        },

        async fetchUserProfile() {
            try {
                const response = await HttpService.get(`/candidate/show/${this.getCandidateId}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                });
                const user = response.data.candidate;
                this.usuario.name_candidate = user.name_candidate || '';
                this.usuario.phone = user.phone || '';
                this.usuario.gender = user.gender || '';
                this.usuario.about_candidate = user.about_candidate || '';
            } catch (error) {
                console.error('Erro ao carregar o perfil do usuário:', error);
            }
        },

        formatPhone(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            this.usuario.phone = input.substring(0, 15);
        },
    },
    mounted() {
        this.usuario.id = this.getCandidateId;
    }
};
</script>

<style scoped>
.vh-100 {
    background-color: #cfcccc;
}

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

.text-center small {
    display: block;
    margin-top: 10px;
}
</style>
