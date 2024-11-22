<template>
    <div>
        <Navbar />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Currículo</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/curriculo" class="list-group-item list-group-item-action">Dados
                                Pessoais</router-link>
                            <router-link to="/experiencia-profissional"
                                class="list-group-item list-group-item-action">Experiência Profissional</router-link>
                            <router-link to="/formacao"
                                class="list-group-item list-group-item-action">Formação</router-link>
                            <router-link to="/conquistas-certificados"
                                class="list-group-item list-group-item-action">Certificados</router-link>
                            <router-link to="/skills"
                                class="list-group-item list-group-item-action">Skills</router-link>
                            <router-link to="/idiomas"
                                class="list-group-item list-group-item-action">Idiomas</router-link>

                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">         
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Anexar Currículo</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="curriculo">Por favor, escolha um arquivo de currículo para anexar. O
                                            formato deve ser
                                            PDF ou DOCX.</label>
                                        <div class="input-group mb-4">
                                            <input type="file" class="form-control" id="inputGroupFile02">
                                        </div>
                                    </div>

                                    <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Navbar from "@/components/Navbar.vue";

export default {
    name: 'AnexarCurriculo',
    data() {
        return {
            components: {
                Navbar,
            },
        };
    }
}
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