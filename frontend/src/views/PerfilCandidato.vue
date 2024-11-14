<template>
    <div>
        <Navbar />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/meu-perfil" class="list-group-item list-group-item-action">
                                Conta
                            </router-link>
                            <router-link to="/data-nascimento" class="list-group-item list-group-item-action">
                                Data de Nascimento
                            </router-link>
                            <router-link to="/email" class="list-group-item list-group-item-action">
                                Email
                            </router-link>
                            <router-link to="/senha" class="list-group-item list-group-item-action">
                                Senha
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Conta</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateConta">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">Nome Completo</label>
                                            <input type="text" class="form-control" id="name"
                                                v-model="usuario.name_candidate" placeholder="Nome Completo">
                                        </div>
                                        <div class="form-group">
                                            <label>Gênero</label>
                                            <div class="genero-options py-2">
                                                <div class="form-check" v-for="(option, index) in genderOptions"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" :name="'gender'"
                                                        :id="option.value" :value="option.value"
                                                        v-model="usuario.gender">
                                                    <label class="form-check-label" :for="option.value">{{
                                                        option.label }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="about_candidate">Sobre você</label>
                                            <textarea rows="2" class="form-control" id="about_candidate"
                                                v-model="usuario.about_candidate"
                                                placeholder="Faça um breve resumo sobre você"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Telefone</label>
                                            <input type="text" class="form-control" id="phone" v-model="usuario.phone"
                                                placeholder="Informe seu Telefone" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <img :src="profileImagePreview || '../../public/user.png'"
                                                alt="Foto do Recrutador" class="rounded-circle img-responsive mt-2"
                                                width="128" height="128">
                                            <div class="mt-2">
                                                <label class="btn btn-primary">
                                                    <i class="fa fa-upload"></i>
                                                    <input type="file" @change="trocarFotoPerfil" hidden>
                                                </label>
                                            </div>
                                            <small>Adicione uma foto de perfil para seu recrutador. Se não
                                                selecionar, será usada a imagem padrão.</small>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar Informações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';

export default {
    components: {
        Navbar
    },
    data() {
        return {
            currentSection: 'conta',
            usuario: {
                id: '',
                name_candidate: '',
                about_candidate: '',
                phone: '',
                gender: '',
                fotoPerfil: null,
            },
            profileImagePreview: '',
            genderOptions: [
                { label: 'Masculino', value: 'masculino' },
                { label: 'Feminino', value: 'feminino' },
                { label: 'Não-Binário', value: 'nao-binario' },
                { label: 'Outro', value: 'outro' },
                { label: 'Prefiro não responder', value: 'sem-resposta' }
            ],
            errors: {},
            token: localStorage.getItem('authToken') || '',
        };
    },
    computed: {
        ...mapGetters(['getCandidateId']),
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        trocarFotoPerfil(event) {
            const file = event.target.files[0];
            if (file) {
                this.profileImagePreview = URL.createObjectURL(file);
                this.usuario.fotoPerfil = file;
            }
        },
        validateFields() {
            this.errors = {};

            if (!this.usuario.name_candidate) {
                this.errors.name_candidate = "O nome é obrigatório.";
            }
            if (!this.usuario.gender) {
                this.errors.gender = "O gênero é obrigatório.";
            }

            return Object.keys(this.errors).length === 0;
        },
        async sendUpdateRequest(formData) {
            try {
                if (!this.token) {
                    alert('Usuário não autenticado!');
                    return;
                }

                const response = await HttpService.put(`/candidate/update/${this.getCandidateId}`, formData, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'multipart/form-data',
                    }
                });

                if (response.data.success) {
                    alert('Informações da conta atualizadas com sucesso.');
                } else {
                    alert('Erro ao atualizar as informações do candidato.');
                }
            } catch (error) {
                console.error("Erro ao atualizar conta:", error);
                alert('Erro ao atualizar informações da conta.');
            }
        },
        async updateConta() {
            if (this.validateFields()) {
                const formData = new FormData();
                formData.append("name_candidate", this.usuario.name_candidate);
                formData.append("about_candidate", this.usuario.about_candidate);
                formData.append("phone", this.usuario.phone); 
                formData.append("gender", this.usuario.gender);
                if (this.usuario.fotoPerfil) {
                    formData.append("fotoPerfil", this.usuario.fotoPerfil);
                }

                await this.sendUpdateRequest(formData);
            }
        }
    },
    mounted() {
        this.usuario.id = this.getCandidateId;
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