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


                                        <form @submit.prevent="login">

                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                                <span class="h1 fw-bold mb-0">3Cvagas</span>
                                            </div>

                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Entre em sua
                                                conta:</h5>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="email" id="form2Example17" v-model="email"
                                                    class="form-control form-control" required />
                                                <label class="form-label" for="form2Example17">Email</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="password" id="form2Example27" v-model="password"
                                                    class="form-control form-control" required />
                                                <label class="form-label" for="form2Example27">Senha</label>
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button type="submit" class="btn btn-dark btn-lg btn-block"
                                                    data-mdb-button-init data-mdb-ripple-init>
                                                    Login
                                                </button>
                                            </div>

                                            <a class="small text-muted" href="#!">Esqueceu sua senha?</a>
                                            <p class="mb-5 pb-lg-2" style="color: #393f81;">Não tem uma conta?
                                                <router-link to="/register"
                                                    style="color: #393f81;">Registre-se</router-link>
                                            </p>
                                            <a href="#!" class="small text-muted">Termos de uso.</a>
                                            <a href="#!" class="small text-muted"> Política de Privacidade</a>
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
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            if (!this.email || !this.password) {
                alert('Por favor, preencha ambos os campos de email e senha.');
                return;
            }

            try {

                console.log('Tentando login como candidato...');
                const response = await HttpService.post('candidate/login', {
                    email: this.email,
                    password: this.password,
                });


                console.log('Login como candidato bem-sucedido:', response.data);
                this.$store.dispatch('login', response.data.token);
                alert('Login realizado com sucesso!');
                this.$router.push('/home-candidato');
            } catch (error) {

                console.error('Erro ao fazer login:', error);
                if (error.response) {
                    console.log('Erro response:', error.response);
                    console.log('Erro response data:', error.response.data);
                    console.log('Erro response status:', error.response.status);
                }

                try {
                    console.log('Tentando login como empresa...');
                    const response = await HttpService.post('company/login', {
                        email: this.email,
                        password: this.password,
                    });

                    console.log('Login como empresa bem-sucedido:', response.data);
                    this.$store.dispatch('login', response.data.token);
                    alert('Login realizado com sucesso!');
                    this.$router.push('/home-empresa');
                } catch (error) {
                    console.error('Erro ao fazer login:', error);
                    if (error.response) {
                        console.log('Erro response:', error.response);
                        console.log('Erro response data:', error.response.data);
                        console.log('Erro response status:', error.response.status);
                    }
                    alert(`Erro: ${error.response ? error.response.data.message : 'Erro ao tentar realizar o login. Tente novamente.'}`);
                }
            }
        }
    }
};
</script>



<style></style>
