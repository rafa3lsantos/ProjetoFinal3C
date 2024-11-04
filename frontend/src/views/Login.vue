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

                                        <form>

                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                                <span class="h1 fw-bold mb-0">3Cvagas</span>
                                            </div>

                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Entre em sua
                                                conta:</h5>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="email" id="form2Example17"
                                                    class="form-control form-control" />
                                                <label class="form-label" for="form2Example17">Email</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="password" id="form2Example27"
                                                    class="form-control form-control" />
                                                <label class="form-label" for="form2Example27">Senha</label>
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <router-link to="/home-candidato" class="btn btn-dark btn-lg btn-block"
                                                    data-mdb-button-init data-mdb-ripple-init>
                                                    Login
                                                </router-link>
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
export default {

}
</script>

<style></style>