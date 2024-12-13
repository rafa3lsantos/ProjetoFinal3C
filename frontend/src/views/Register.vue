<template>
    <div>
        <section class="vh-100" style="background-color: #cfcccc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block">
                                    <img src="../../public/designer-working-3d-model.jpg" alt="login form"
                                        class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form @submit.prevent="registerCandidate">
                                            <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Registre-se:
                                            </h5>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">Nome Completo</label>
                                                <input type="text" v-model="name_candidate" class="form-control"
                                                    required />
                                            </div>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">CPF</label>
                                                <input type="text" v-model="cpf" class="form-control" required
                                                    @input="formatCPF" maxlength="14" />
                                            </div>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">Email</label>
                                                <input type="email" v-model="email" class="form-control" required />
                                            </div>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">Crie sua senha</label>
                                                <input type="password" v-model="password" class="form-control"
                                                    required />
                                            </div>
                                            <div class="form-outline mb-2">
                                                <label class="form-label">Confirme sua senha</label>
                                                <input type="password" v-model="password_confirmation"
                                                    class="form-control" required />
                                            </div>

                                            <div class="form-check d-flex justify-content-center mb-3">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    v-model="termsAccepted" />
                                                <label class="form-check-label">
                                                    Concordo com os <a href="#!" class="text-body"><u>Termos de
                                                            serviço</u></a>
                                                </label>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success btn-block btn-lg">
                                                    Registre-se
                                                </button>
                                            </div>

                                            <p class="text-center text-muted mt-4 mb-0">
                                                É uma empresa?
                                                <router-link to="/register-empresa"
                                                    class="fw-bold text-body"><u>Registrar-se</u></router-link>
                                                Já tem uma conta?
                                                <router-link to="/login"
                                                    class="fw-bold text-body"><u>Login</u></router-link>
                                            </p>
                                        </form>

                                    </div>
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
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    data() {
        return {
            name_candidate: '',
            cpf: '',
            email: '',
            password: '',
            password_confirmation: '',
            termsAccepted: false,
        };
    },
    methods: {
        showSuccessToast(message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#28a745",
                color: "white",
                close: true,
            }).showToast();
        },
        showErrorToast(message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#dc3545",
                color: "white",
                close: true,
            }).showToast();
        },
        async registerCandidate() {
            if (!this.termsAccepted) {
                this.showErrorToast("Você deve aceitar os termos de serviço.");
                return;
            }

            if (this.password !== this.password_confirmation) {
                this.showErrorToast("As senhas não coincidem.");
                return;
            }

            try {
                const response = await HttpService.post('candidate/register', {
                    name_candidate: this.name_candidate,
                    cpf: this.cpf,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                this.showSuccessToast("Registro concluído com sucesso!");

                const loginResponse = await HttpService.post('candidate/login', {
                    email: this.email,
                    password: this.password,
                });

                this.$store.dispatch('login', {
                    token: loginResponse.data.token,
                    role: 'candidato',
                    candidateId: loginResponse.data.candidate_id,
                    curriculumId: loginResponse.data.curriculum_id,
                });

                this.$router.push('/home-candidato');
            } catch (error) {
                console.error("Erro ao registrar o candidato:", error);
                this.showErrorToast("Erro ao registrar. Verifique os dados e tente novamente.");
            }
        },
        formatCPF(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            this.cpf = input.substring(0, 14);
        },
    },
};
</script>

<style scoped>
.vh-100 {
    background-color: #cfcccc;
}
</style>
