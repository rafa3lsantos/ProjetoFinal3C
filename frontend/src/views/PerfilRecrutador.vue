<template>
    <div>
        <NavbarRecrutador />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/perfil-recrutador"
                                class="list-group-item list-group-item-action">Conta</router-link>
                            <router-link to="/add-vaga" class="list-group-item list-group-item-action">Adicionar
                                Vaga</router-link>
                            <router-link to="/minhas-vagas" class="list-group-item list-group-item-action">Minhas
                                Vagas</router-link>
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
                                                v-model="recruiter.recruiter_name" placeholder="Nome Completo">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                v-model="recruiter.email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label>Gênero</label>
                                            <div class="genero-options py-2">
                                                <div class="form-check" v-for="(option, index) in genderOptions"
                                                    :key="index">
                                                    <input class="form-check-input" type="radio" :name="'gender'"
                                                        :id="option.value" :value="option.value"
                                                        v-model="recruiter.recruiter_gender">
                                                    <label class="form-check-label" :for="option.value">{{ option.label
                                                        }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Telefone</label>
                                            <input type="text" class="form-control" id="phone"
                                                v-model="recruiter.recruiter_phone" placeholder="Informe seu Telefone"
                                                @input="formatPhone" maxlength="15" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="mt-2">
                                                <img class="rounded-circle mt-5" width="150px"
                                                    :src="recruiter.recruiter_photo" alt="Imagem de Perfil">
                                                <input type="file" @change="onImageChange" style="display: none;"
                                                    ref="fileInput" />
                                                <button type="button" class="btn btn-primary mt-3"
                                                    @click="triggerFileInput">Alterar Imagem</button>
                                            </div>
                                            <small>Adicione uma foto de perfil. Se não selecionar, será usada a imagem
                                                padrão.</small>
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
import NavbarRecrutador from '@/components/NavbarRecrutador.vue';
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    components: {
        NavbarRecrutador
    },
    data() {
        return {
            recruiter: {
                id: '',
                email: '',
                recruiter_name: '',
                recruiter_phone: '',
                recruiter_gender: '',
                recruiter_photo: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg',
            },
            profileImagePreview: '',
            genderOptions: [
                { label: 'Masculino', value: 'male' },
                { label: 'Feminino', value: 'female' },
                { label: 'Não-Binário', value: 'non-binary' },
                { label: 'Outro', value: 'other' },
                { label: 'Prefiro não responder', value: 'prefer not to say' },
            ],
            errors: {},
            token: localStorage.getItem('authToken') || ''
        };
    },
    created() {
        this.fetchRecruiter();
    },
    computed: {
        ...mapGetters(['getRecruiterId'])
    },
    methods: {
        showToast(type, message) {
            let backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            Toastify({
                text: message,
                duration: 1000,
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
                this.recruiter.recruiter_photo_file = file;
                const reader = new FileReader();
                reader.onload = () => {
                    this.recruiter.recruiter_photo = reader.result;
                };
                reader.readAsDataURL(file);
            }
        },

        async sendUpdateRequest() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const updateResponse = await HttpService.put(
                    `/recruiter/update/${this.getRecruiterId}`,
                    this.recruiter,
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }
                );

                if (updateResponse.status !== 200) {
                    this.showToast('error', 'Erro ao atualizar as informações do recrutador.');
                    return;
                }

                if (this.recruiter.recruiter_photo_file) {
                    const formData = new FormData();
                    formData.append('image', this.recruiter.recruiter_photo_file);

                    const uploadResponse = await HttpService.post(
                        '/recruiter/upload-profile-image',
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
            console.log("Botão de salvar clicado");
            await this.sendUpdateRequest();
        },

        async fetchRecruiter() {
            try {
                const response = await HttpService.get(`/recruiter/show/${this.getRecruiterId}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                });
                const recruiter = response.data.recruiter;
                this.recruiter.recruiter_name = recruiter.recruiter_name || '';
                this.recruiter.email = recruiter.email || '';
                this.recruiter.recruiter_phone = recruiter.recruiter_phone || '';
                this.recruiter.recruiter_gender = recruiter.recruiter_gender || '';

                if (recruiter.recruiter_photo) {
                    console.log(recruiter.recruiter_photo);
                    this.recruiter.recruiter_photo = `http://127.0.0.1:8000/storage/${recruiter.recruiter_photo}`;
                }
            } catch (error) {
                console.error('Erro ao carregar o perfil do recrutador:', error);
            }
        },

        formatPhone(event) {
            let input = event.target.value;
            input = input.replace(/\D/g, '');
            input = input.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            this.recruiter.recruiter_phone = input.substring(0, 15);
        },

        triggerFileInput() {
            this.$refs.fileInput.click();
        }
    },
    mounted() {
        this.recruiter.id = this.getRecruiterId;
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
</style>
