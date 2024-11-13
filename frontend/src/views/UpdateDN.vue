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
                                <h5 class="card-title mb-0">Data de Nascimento</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="salvarDataNascimento">
                                    <div class="form-group">
                                        <label for="birthdate">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="birthdate"
                                            v-model="usuario.birthdate">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
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
                email: '',
                password: '',
                new_password: '',
                about_candidate: '',
                birthdate: '',
                gender: '',
                phone: '',
                fotoPerfil: null,
                curriculum: ''
            },
            profileImagePreview: '',
            senhaAtual: '',
            passwordNew: '',
            confirmarSenha: '',
            genderOptions: [
                { label: 'Masculino', value: 'masculino' },
                { label: 'Feminino', value: 'feminino' },
                { label: 'Não-Binário', value: 'nao-binario' },
                { label: 'Outro', value: 'outro' },
                { label: 'Prefiro não responder', value: 'sem-resposta' }
            ],
            errors: {}
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
            if (!this.usuario.email || !this.isValidEmail(this.usuario.email)) {
                this.errors.email = "Informe um e-mail válido.";
            }
            if (!this.usuario.gender) {
                this.errors.gender = "O gênero é obrigatório.";
            }
            if (this.senhaAtual && (!this.passwordNew || !this.confirmarSenha)) {
                this.errors.password = "A nova senha e confirmação são obrigatórias.";
            }

            return Object.keys(this.errors).length === 0;
        },
        isValidEmail(email) {
            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(String(email).toLowerCase());
        },
        updateConta() {
            if (this.validateFields()) {
                const formData = new FormData();
                formData.append("name_candidate", this.usuario.name_candidate);
                formData.append("about_candidate", this.usuario.about_candidate);
                formData.append("phone", this.usuario.phone);
                formData.append("gender", this.usuario.gender);
                if (this.usuario.fotoPerfil) {
                    formData.append("fotoPerfil", this.usuario.fotoPerfil);
                }

                HttpService.put(`/candidates/update/${this.getCandidateId}`, formData)
                    .then(() => {
                        alert('Informações da conta atualizadas com sucesso.');
                    })
                    .catch(error => {
                        console.error("Erro ao atualizar conta:", error);
                    });
            }
        },
        salvarDataNascimento() {
            if (this.validateFields()) {
                const formData = new FormData();
                formData.append("birthdate", this.usuario.birthdate);

                HttpService.put(`/candidates/update/${this.getCandidateId}`, formData)
                    .then(() => {
                        alert('Data de nascimento atualizada com sucesso.');
                    })
                    .catch(error => {
                        console.error("Erro ao atualizar data de nascimento:", error);
                    });
            }
        },
        salvarEmail() {
            if (this.validateFields()) {
                const formData = new FormData();
                formData.append("email", this.usuario.email);

                HttpService.put(`/candidates/update/${this.getCandidateId}`, formData)
                    .then(() => {
                        alert('Email atualizado com sucesso.');
                    })
                    .catch(error => {
                        console.error("Erro ao atualizar email:", error);
                    });
            }
        },
        salvarSenha() {
            if (this.passwordNew !== this.confirmarSenha) {
                alert('As senhas não coincidem.');
                return;
            }

            const formData = new FormData();
            formData.append("password_current", this.senhaAtual);
            formData.append("password_new", this.passwordNew);

            HttpService.put(`/candidates/update/${this.getCandidateId}`, formData)
                .then(() => {
                    alert('Senha alterada com sucesso.');
                })
                .catch(error => {
                    console.error("Erro ao alterar senha:", error);
                });
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