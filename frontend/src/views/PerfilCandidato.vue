<template>
    <div>
        <Navbar />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/meu-perfil"
                                class="list-group-item list-group-item-action">Conta</router-link>
                            <router-link to="/data-nascimento" class="list-group-item list-group-item-action">Data de
                                Nascimento</router-link>
                            <router-link to="/email" class="list-group-item list-group-item-action">Email</router-link>
                            <router-link to="/senha" class="list-group-item list-group-item-action">Senha</router-link>
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
                                                    <label class="form-check-label" :for="option.value">{{ option.label
                                                        }}</label>
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
                                                placeholder="Informe seu Telefone" @input="formatPhone"
                                                maxlength="15" />
                                        </div>

                                        <div class="form-group">
                                            <label for="cep">CEP</label>
                                            <input type="text" class="form-control" id="cep" v-model="usuario.cep"
                                                placeholder="Informe seu CEP" @input="formatCEP" maxlength="9" />
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Endereço</label>
                                            <input type="text" class="form-control" id="address"
                                                v-model="usuario.address" placeholder="Informe seu Endereço" />
                                        </div>

                                        <div class="form-group">
                                            <label for="state">state</label>
                                            <input type="text" class="form-control" id="state" v-model="usuario.state"
                                                placeholder="Sigla do estado" maxlength="2" />
                                        </div>


                                        <div class="form-group">
                                            <label for="city">Cidade</label>
                                            <input type="text" class="form-control" id="city" v-model="usuario.city"
                                                placeholder="Informe sua cidade" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="mt-2">
                                                <img class="rounded-circle mt-5" width="150px"
                                                    :src="usuario.perfilPicture" alt="Imagem de Perfil">
                                                <input type="file" @change="onImageChange" style="display: none;"
                                                    ref="fileInput" />
                                                <button type="button" class="btn btn-primary mt-3"
                                                    @click="triggerFileInput">Alterar Imagem</button>

                                            </div>
                                            <small>Adicione uma foto de perfil para seu recrutador. Se não selecionar,
                                                será usada a imagem padrão.</small>
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
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    components: {
        Navbar
    },
    data() {
        return {
            usuario: {
                id: '',
                name_candidate: '',
                about_candidate: '',
                phone: '',
                gender: '',
                cep: '',
                address: '',
                state: '',
                city: '',
                perfilPicture: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'
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
    created() {
        this.fetchUserProfile();
    },
    computed: {
        ...mapGetters(['getCandidateId'])
    },
    methods: {
        showToast(type, message) {
            let backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            Toastify({
                text: message,
                duration: 3000,
                gravity: 'top',
                position: 'center',
                backgroundColor: backgroundColor,
                color: 'white',
                close: true,
                offset: { x: 50, y: 50 },
            }).showToast();
        },

        onImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.usuario.perfilPictureFile = file;
                const reader = new FileReader();
                reader.onload = () => {
                    this.usuario.perfilPicture = reader.result;
                };
                reader.readAsDataURL(file);
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

        async sendUpdateRequest() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const updateResponse = await HttpService.put(
                    `/candidate/update/${this.getCandidateId}`,
                    this.usuario,
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }
                );

                if (updateResponse.status !== 200) {
                    this.showToast('error', 'Erro ao atualizar as informações do candidato.');
                    return;
                }

                if (this.usuario.perfilPictureFile) {
                    const formData = new FormData();
                    formData.append('image', this.usuario.perfilPictureFile);

                    const uploadResponse = await HttpService.post(
                        '/candidate/upload-profile-image',
                        formData,
                        {
                            headers: {
                                'Authorization': `Bearer ${this.token}`,
                                'Content-Type': 'multipart/form-data',
                            },
                        }
                    );

                    if (uploadResponse.status !== 200) {
                        this.showToast('error', 'Erro ao fazer upload da imagem de perfil.');
                        return;
                    }
                }

                this.showToast('success', 'Informações da conta atualizadas com sucesso.');
            } catch (error) {
                console.error("Erro ao atualizar conta:", error);
                this.showToast('error', 'Erro ao atualizar informações da conta.');
            }
        },

        async updateConta() {
            if (this.validateFields()) {
                await this.sendUpdateRequest();
            }
        },

        async fetchUserProfile() {
            try {
                const response = await HttpService.get(`/candidate/show/${this.getCandidateId}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                });
                const user = response.data.candidate;
                this.usuario.name_candidate = user.name_candidate || '';
                this.usuario.phone = user.phone || '';
                this.usuario.gender = user.gender || '';
                this.usuario.about_candidate = user.about_candidate || '';
                this.usuario.cep = user.cep || '';
                this.usuario.address = user.address || '';
                this.usuario.state = user.state || '';
                this.usuario.city = user.city || '';

                if (user.photo) {
                    this.usuario.perfilPicture = `http://127.0.0.1:8000/storage/${user.photo}`;
                }
            } catch (error) {
                console.error('Erro ao carregar o perfil do usuário:', error);
            }
        },

        formatPhone(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            this.usuario.phone = input.substring(0, 15);
        },

        triggerFileInput() {
            this.$refs.fileInput.click();
        },

        formatCEP(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/(\d{5})(\d{3})/, '$1-$2');
            this.usuario.cep = input.substring(0, 9);
        },



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
