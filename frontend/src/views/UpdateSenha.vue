<template>
    <div>
        <Navbar />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/meu-perfil" class="list-group-item list-group-item-action">
                                Conta
                            </router-link>
                            <router-link to="/data-nascimento" class="list-group-item list-group-item-action">
                                Data de Nascimento
                            </router-link>
                            <router-link to="/email" class="list-group-item list-group-item-action">
                                Email
                            </router-link>
                            <router-link to="/senha" class="list-group-item list-group-item-action">
                                Senha
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Atualizar Senha</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="salvarSenha">
                                <div class="form-group">
                                    <label for="passwordCurrent">Senha Atual</label>
                                    <input type="password" class="form-control" id="passwordCurrent"
                                        v-model="senhaAtual" placeholder="Digite sua senha atual" required>
                                    <span v-if="errors.senhaAtual" class="text-danger">{{ errors.senhaAtual }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="passwordNew">Nova Senha</label>
                                    <input type="password" class="form-control" id="passwordNew" v-model="passwordNew"
                                        placeholder="Digite a nova senha" required>
                                    <span v-if="errors.passwordNew" class="text-danger">{{ errors.passwordNew }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        v-model="password_confirmation" placeholder="Confirme a nova senha" required>
                                    <span v-if="errors.password_confirmation" class="text-danger">{{
                                        errors.password_confirmation }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Alterar Senha</button>
                            </form>
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
import { mapGetters } from 'vuex';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    components: {
        Navbar
    },
    data() {
        return {
            senhaAtual: '',
            passwordNew: '',
            password_confirmation: '',
            errors: {}
        };
    },
    computed: {
        ...mapGetters(['getCandidateId', 'getAuthToken']),
    },
    methods: {
        validateFields() {
            this.errors = {};
            if (!this.senhaAtual) {
                this.errors.senhaAtual = "A senha atual é obrigatória.";
            }

            if (!this.passwordNew) {
                this.errors.passwordNew = "A nova senha é obrigatória.";
            }

            if (this.passwordNew !== this.password_confirmation) {
                this.errors.password_confirmation = "As senhas não coincidem.";
            }

            return Object.keys(this.errors).length === 0;
        },

        async salvarSenha() {
            if (this.validateFields()) {
                const data = {
                    password: this.senhaAtual,
                    new_password: this.passwordNew,
                    new_password_confirmation: this.password_confirmation
                };

                try {
                    const response = await HttpService.put(`/candidate/update-password`, data, {
                        headers: {
                            'Authorization': `Bearer ${this.getAuthToken}`
                        }
                    });

                    Toastify({
                        text: "Senha alterada com sucesso.",
                        backgroundColor: "green",
                        position: "center", // Centraliza a notificação
                        duration: 3000,
                    }).showToast();
                } catch (error) {
                    console.error("Erro ao alterar senha:", error);
                    const errorMessage = error.response && error.response.data.message
                        ? error.response.data.message
                        : 'Erro ao atualizar a senha. Por favor, tente novamente.';
                    Toastify({
                        text: errorMessage,
                        backgroundColor: "red",
                        position: "center", // Centraliza a notificação
                        duration: 3000,
                    }).showToast();
                }
            }
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

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e5e9f2;
    border-radius: .2rem;
}

.card-header:first-child {
    border-radius: calc(.2rem - 1px) calc(.2rem - 1px) 0 0;
}

.card-header {
    border-bottom-width: 1px;
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    color: inherit;
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
