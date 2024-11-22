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
                            <router-link to="/curriculo" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('dadosPessoais')">Dados Pessoais</router-link>
                            <router-link to="/experiencia-profissional" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('experienciaProfissional')">Experiência
                                Profissional</router-link>
                            <router-link to="/formacao" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('formacao')">Formação</router-link>
                            <router-link to="/conquistas-certificados" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('certificados')">Certificados</router-link>
                            <router-link to="/skills" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('skills')">Skills</router-link>
                            <router-link to="/idiomas" class="list-group-item list-group-item-action"
                                @click.prevent="showSection('idiomas')">Idiomas</router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Experiência Profissional</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateExperience">
                                <div v-for="(experiencia, index) in experiencias" :key="index">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label :for="'empresa' + index">Empresa</label>
                                            <input type="text" class="form-control" :id="'empresa' + index"
                                                v-model="experiencia.empresa" placeholder="Digite o nome da empresa">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label :for="'cargo' + index">Cargo</label>
                                                <input type="text" class="form-control" :id="'cargo' + index"
                                                    v-model="experiencia.cargo" placeholder="Cargo que exercia">
                                            </div>
                                        </div>
                                        <div>
                                            <label>Meu emprego Atual</label>
                                            <div class="genero-options py-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="experiencia.empregoAtual">
                                                    <label class="form-check-label">Emprego Atual</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label :for="'inicio' + index">Início</label>
                                            <input type="text" class="form-control" :id="'inicio' + index"
                                                v-model="experiencia.inicio" placeholder="dd/mm/aaaa">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label :for="'fim' + index">Fim</label>
                                            <input type="text" class="form-control" :id="'fim' + index"
                                                v-model="experiencia.fim" placeholder="dd/mm/aaaa">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label :for="'descricao' + index">Descrição das atividades</label>
                                            <textarea class="form-control" :id="'descricao' + index"
                                                v-model="experiencia.descricao" rows="4"
                                                placeholder="Descreva as atividades..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <a href="#" @click.prevent="adicionarExperiencia" class="disabled-link">
                                        <img width="20" src="../../public/add.png" alt="">
                                        Adicionar outra experiência profissional.
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
import HttpService from "../services/HttpService";
import { mapGetters } from "vuex";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            experiencias: [
                {
                    empresa: '',
                    cargo: '',
                    empregoAtual: false,
                    inicio: '',
                    fim: '',
                    descricao: ''
                }
            ],
            errors: {},
            token: localStorage.getItem("authToken") || "",
        };
    },
    computed: {
        ...mapGetters(["getCandidateId"]),
    },
    methods: {
        validateFields() {
            this.errors = {};
            let isValid = true;
            this.experiencias.forEach((experiencia, index) => {
                if (!experiencia.empresa || !experiencia.cargo) {
                    this.errors[`experiencia${index}`] = "Empresa e Cargo são obrigatórios.";
                    isValid = false;
                }
            });
            return isValid;
        },
        adicionarExperiencia() {
            this.experiencias.push({
                empresa: '',
                cargo: '',
                empregoAtual: false,
                inicio: '',
                fim: '',
                descricao: ''
            });
        },
        async updateExperience() {
            if (this.validateFields()) {
                try {
                    const response = await HttpService.put(
                        `/curriculum/update/${this.getCandidateId}`,
                        {
                            curriculum: {
                                experiencias: this.experiencias,
                            },
                        },
                        {
                            headers: {
                                Authorization: `Bearer ${this.token}`,
                                "Content-Type": "application/json",
                            },
                        }
                    );

                    if (response.status === 200) {
                        alert("Experiências atualizadas com sucesso.");
                    } else {
                        alert("Erro ao atualizar as experiências.");
                    }
                } catch (error) {
                    console.error("Erro ao atualizar as experiências:", error);
                    alert("Erro ao salvar os dados.");
                }
            } else {
                alert("Por favor, preencha todos os campos obrigatórios.");
            }
        },


        async fetchUserProfile() {
            try {
                const response = await HttpService.put(
                    `/curriculum/update/${this.getCandidateId}`,
                    {
                        experiencias: this.experiencias,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                            "Content-Type": "application/json",
                        },
                    }
                );


                const user = response.data.curriculo;
                this.experiencias = user.experiencias || this.experiencias;
            } catch (error) {
                console.error("Erro ao carregar o perfil do usuário:", error);
                alert("Erro ao carregar o perfil.");
            }
        },
    },
    mounted() {
        this.fetchUserProfile();
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
    margin-bottom: 1.5rem;
}

.disabled-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
}

.disabled-link:hover {
    color: #0056b3;
}

.form-group textarea {
    height: 80px;
}
</style>
