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
                            <h5 class="card-title mb-0">Formação</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div v-for="(formacao, index) in formacoes" :key="index">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="formacao{{ index }}">Formação</label>
                                            <select id="'formacao' + index" class="form-control"
                                                v-model="formacao.formacao">
                                                <option selected="">Selecione a formação</option>
                                                <option>Graduação</option>
                                                <option>Pós-Graduação</option>
                                                <option>Técnico</option>
                                                <option>Outro</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="grau{{ index }}">Grau</label>
                                            <select id="'grau' + index" class="form-control" v-model="formacao.grau">
                                                <option selected="">Selecione o grau</option>
                                                <option>Bacharel</option>
                                                <option>Licenciatura</option>
                                                <option>Tecnólogo</option>
                                                <option>Mestrado</option>
                                                <option>Doutorado</option>
                                                <option>Outro</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="status{{ index }}">Status</label>
                                            <select id="'status' + index" class="form-control"
                                                v-model="formacao.status">
                                                <option selected="">Selecione o status</option>
                                                <option>Concluído</option>
                                                <option>Cursando</option>
                                                <option>Trancado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="curso{{ index }}">Curso</label>
                                            <input type="text" class="form-control" :id="'curso' + index"
                                                v-model="formacao.curso" placeholder="Nome do curso">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="instituicao{{ index }}">Instituição</label>
                                            <input type="text" class="form-control" :id="'instituicao' + index"
                                                v-model="formacao.instituicao" placeholder="Nome da instituição">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inicio{{ index }}">Início</label>
                                            <input type="text" class="form-control" :id="'inicio' + index"
                                                v-model="formacao.inicio" placeholder="dd/mm/aaaa">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="fim{{ index }}">Fim</label>
                                            <input type="text" class="form-control" :id="'fim' + index"
                                                v-model="formacao.fim" placeholder="dd/mm/aaaa">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <a href="#" @click.prevent="adicionarFormacao" class="disabled-link">
                                        <img width="20" src="../../public/add.png" alt="">
                                        Adicionar outra formação.
                                    </a>
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
    name: 'Formacao',
    components: {
        Navbar,
    },
    data() {
        return {

        };
    },
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