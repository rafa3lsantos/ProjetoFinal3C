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
                                        <form @submit.prevent="registerCompany">
                                            <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">
                                                Registre-se:
                                            </h5>
                                            <div class="form-outline mb-2">
                                                <label class="form-label">Nome da Empresa</label>
                                                <input type="text" v-model="company_name" class="form-control"
                                                    required />
                                            </div>
                                            <div class="form-outline mb-2">
                                                <label class="form-label">CNPJ</label>
                                                <input type="text" v-model="company_cnpj" class="form-control" required
                                                    @input="formatCNPJ" maxlength="18" />
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
                                                <label class="form-label">Repita a senha</label>
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
                                                É um candidato?
                                                <router-link to="/register" class="fw-bold text-body">
                                                    <u>Registrar-se</u>
                                                </router-link>
                                                Já tem uma conta?
                                                <router-link to="/login" class="fw-bold text-body">
                                                    <u>Login</u>
                                                </router-link>
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
import "toastify-js/src/toastify.css";

export default {
    data() {
        return {
            company_name: '',
            company_cnpj: '',
            email: '',
            password: '',
            password_confirmation: '',
            termsAccepted: false,
        };
    },
    methods: {
        async registerCompany() {
            if (!this.termsAccepted) {
                this.showToast("Você deve aceitar os termos de serviço.", "error");
                return;
            }

            if (this.password !== this.password_confirmation) {
                this.showToast("As senhas não coincidem.", "error");
                return;
            }

            try {
                const response = await HttpService.post('company/register', {
                    company_name: this.company_name,
                    company_cnpj: this.company_cnpj,
                    email: this.email,
                    password: this.password,
                });
                console.log(response);

                this.showToast("Registro concluído com sucesso!", "success");
                this.$router.push('/home-empresa');
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error("Erro ao registrar a empresa:", error.response.data);
                    this.showToast(error.response.data.message || "Verifique os dados e tente novamente.", "error");
                } else {
                    console.error("Erro ao registrar a empresa:", error);
                    this.showToast("Erro ao registrar. Verifique os dados e tente novamente.", "error");
                }
            }
        },
        formatCNPJ(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
            this.company_cnpj = input.substring(0, 18);
        },
        showToast(message, type) {
            const colors = {
                success: "#28a745",
                error: "#dc3545",
                info: "#007bff",
            };
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: colors[type] || "#000",
                stopOnFocus: true,
            }).showToast();
        }
    }
};
</script>

<style scoped>
.vh-100 {
    background-color: #cfcccc;
}
</style>
