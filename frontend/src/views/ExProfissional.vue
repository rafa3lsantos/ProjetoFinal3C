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
            token: localStorage.getItem("authToken") || "",
        };
    },
    computed: {
        ...mapGetters(["getCurriculumId"]),
    },
    methods: {
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
        async saveCurriculum() {
            // Verificando os dados antes de enviar
            console.log('Dados do currículo antes do envio:', {
                name_candidate: this.name_candidate,
                email: this.email,
                phone: this.phone,
                experience: this.experience,
                // ... outros campos relevantes
            });

            try {
                const response = await HttpService.put(
                    `/curriculum/update/${this.getCurriculumId}`,
                    {
                        curriculum: {
                            name_candidate: this.name_candidate,
                            email: this.email,
                            phone: this.phone,
                            experience: this.experience,
                        }
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                            "Content-Type": "application/json",
                        },
                    }
                );

                console.log('Resposta do servidor:', response.data);
            } catch (error) {
                console.error("Erro ao salvar o currículo:", error);
            }
        },


        async updateExperience() {
            await this.saveCurriculum();
        },
        async fetchUserProfile() {
            try {
                const response = await HttpService.get(
                    `/curriculum/${this.getCurriculumId}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                const user = response.data.curriculo;
                this.experiencias = user.experiencias || this.experiencias;
            } catch (error) {
                console.error("Erro ao buscar o perfil do usuário:", error);
                alert("Erro ao carregar as informações do currículo.");
            }
        },
    },
    mounted() {
        this.fetchUserProfile();
    }
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

.card-header {
    border-bottom-width: 1px;
    padding: .75rem 1.25rem;
    background-color: #fff;
    border-bottom: 1px solid #e5e9f2;
}

.genero-options {
    display: flex;
    flex-wrap: wrap;
}

.form-check {
    margin-right: 15px;
}

.form-group {
    margin-bottom: 30px;
}

.text-center small {
    display: block;
    margin-top: 10px;
}
</style>
