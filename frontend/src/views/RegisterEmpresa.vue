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

                                            <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Registre-se:
                                            </h5>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">Nome da Empresa</label>
                                                <input type="text" v-model="nome" class="form-control"
                                                    required />
                                            </div>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">CNPJ</label>
                                                <input type="text" v-model="cnpj" class="form-control" required />
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

                                            <!-- <div class="form-outline mb-2">
                                                <label class="form-label">Repita a senha</label>
                                                <input type="password" v-model="passwordConfirmation"
                                                    class="form-control" required />
                                            </div> -->

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
                                                <router-link to="/register"
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

export default {
    data() {
        return {
            nome: '',
            cnpj: '',
            email: '',
            password: '',
            // passwordConfirmation: '',
            termsAccepted: false,
        };
    },
    methods: {
        async registerCompany() {
            if (!this.termsAccepted) {
                alert('Você deve aceitar os termos de serviço.');
                return;
            }

            // if (this.password !== this.passwordConfirmation) {
            //     alert('As senhas não coincidem.');
            //     return;
            // }

            try {
                const response = await HttpService.post('company/register', {
                    nome: this.nome,
                    cnpj: this.cnpj,
                    email: this.email,
                    password: this.password,
                });
                console.log(response);

                alert('Registro concluído com sucesso!');
                this.$router.push('/home-empresa');
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error("Erro ao registrar a empresa:", error.response.data);
                    alert(`Erro: ${error.response.data.message || 'Verifique os dados e tente novamente.'}`);
                } else {
                    console.error("Erro ao registrar a empresa:", error);
                    alert('Erro ao registrar. Verifique os dados e tente novamente.');
                }
            }
        }
    }
};
</script>

<style scoped>
.vh-100 {
    background-color: #cfcccc;
}
</style>
