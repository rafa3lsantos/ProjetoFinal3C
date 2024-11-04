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

                                            <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Registre-se:
                                            </h5>

                                            <div data-mdb-input-init class="form-outline mb-2">
                                                <label class="form-label" for="form2Example17">Nome da Empresa</label>
                                                <input type="email" id="form2Example17"
                                                    class="form-control form-control" />
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-2">
                                                <label class="form-label" for="form2Example17">CNPJ</label>
                                                <input type="email" id="form2Example17"
                                                    class="form-control form-control" />
                                            </div>  

                                            <div data-mdb-input-init class="form-outline mb-2">
                                                <label class="form-label" for="form2Example17">Email</label>
                                                <input type="email" id="form2Example17"
                                                    class="form-control form-control" />
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-2">
                                                <label class="form-label" for="form2Example27">Senha</label>
                                                <input type="password" id="form2Example27"
                                                    class="form-control form-control" />
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-2">
                                                <label class="form-label" for="form2Example17">Repetir Senha</label>
                                                <input type="email" id="form2Example17"
                                                    class="form-control form-control" />
                                            </div>

                                            <div class="form-check d-flex justify-content-center mb-3">
                                                <input class="form-check-input me-2" type="checkbox" value=""
                                                    id="form2Example3cg" />

                                                <label class="form-check-label" for="form2Example3g">
                                                    Concordo com os <a href="#!" class="text-body"><u>Termos de
                                                            serviço</u></a>
                                                </label>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Registre-se</button>
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
export default {

}
</script>

<style></style>