<template>
    <div>
        <link rel="stylesheet" href="node_modules/toastify-js/src/toastify.css">
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

                                            <div class="form-floating mb-4">
                                                <input type="email" class="form-control" id="email" v-model="email"
                                                    placeholder="name@example.com" required />
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input type="password" class="form-control" id="password"
                                                    v-model="password" placeholder="Password" required />
                                                <label for="password">Senha</label>
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button type="submit" class="btn btn-dark btn-lg btn-block">
                                                    Login
                                                </button>
                                            </div>

                                            <a class="small text-muted" href="#!">Esqueceu sua senha?</a>
                                            <p class="mb-5 pb-lg-2" style="color: #393f81;">
                                                Não tem uma conta?
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
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
 
        showSuccessToast() {
            Toastify({
                text: "Login realizado com sucesso!",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#28a745",
                color: "white",
                close: true,
                offset: { x: 50, y: 50 },
            }).showToast();
        },


        showErrorToast() {
            Toastify({
                text: "Ocorreu um erro!",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#dc3545",
                color: "white",
                close: true,
                offset: { x: 50, y: 50 },
            }).showToast();
        },
        async login() {
            if (!this.email || !this.password) {
                this.showErrorToast();
                return;
            }

            try {
                const recruiterResponse = await HttpService.post('recruiter/login', {
                    email: this.email,
                    password: this.password,
                });

                this.$store.dispatch('login', {
                    token: recruiterResponse.data.token,
                    role: 'recrutador',
                    recruiterId: recruiterResponse.data.recruiter_id,
                    companyId: recruiterResponse.data.company_id,
                });
                this.showSuccessToast();
                this.$router.push('/home-recrutador');
            } catch (error) {
                console.error(error);
                try {
                    const candidateResponse = await HttpService.post('candidate/login', {
                        email: this.email,
                        password: this.password,
                    });

                    this.$store.dispatch('login', {
                        token: candidateResponse.data.token,
                        role: 'candidato',
                        candidateId: candidateResponse.data.candidate_id,
                        curriculumId: candidateResponse.data.curriculum_id,
                    });
                    this.showSuccessToast();
                    this.$router.push('/home-candidato');
                } catch (error) {
                    console.error(error);
                    try {
                        const companyResponse = await HttpService.post('company/login', {
                            email: this.email,
                            password: this.password,
                        });

                        this.$store.dispatch('login', {
                            token: companyResponse.data.token,
                            role: 'empresa',
                            companyId: companyResponse.data.company_id,
                        });
                        this.showSuccessToast();
                        this.$router.push('/home-empresa');
                    } catch (error) {
                        console.error(error);
                        this.showErrorToast();
                    }
                }
            }
        },
    },
};
</script>

<style scoped>
.form-outline {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
}

.form-label {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 16px;
    transition: all 0.2s ease-in-out;
    pointer-events: none;
}

.form-control:focus+.form-label,
.form-control:not(:placeholder-shown)+.form-label {
    top: 0;
    left: 10px;
    font-size: 12px;
    color: #333;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.entryarea {
    position: relative;
    height: 80px;
    line-height: 80px;
}

.toastify-toast {
    border-radius: 12px;
    font-family: 'Arial', sans-serif;
    font-size: 16px;
    padding: 15px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: white;
    text-align: center;
}

.toastify-toast.success {
    background-color: #28a745;
}

.toastify-toast.error {
    background-color: #dc3545;
}

.toastify-close {
    color: white;
    font-size: 18px;
}
</style>
