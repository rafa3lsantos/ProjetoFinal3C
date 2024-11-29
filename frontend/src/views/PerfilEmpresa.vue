<template>
    <div>
        <NavbarEmpresa />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil Empresa</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <router-link to="/perfil-empresa" class="list-group-item list-group-item-action"
                                active-class="active">Empresa</router-link>

                            <router-link to="/add-recrutador" class="list-group-item list-group-item-action"
                                active-class="active">Adicionar Recrutador</router-link>

                            <router-link to="/recrutadores" class="list-group-item list-group-item-action"
                                active-class="active">Recrutadores</router-link>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Empresa</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateConta">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">Nome da Empresa</label>
                                            <input type="text" v-model="empresa.company_name" class="form-control"
                                                id="name" placeholder="Nome da sua empresa" required>
                                            <div v-if="errors.company_name" class="text-danger">{{ errors.company_name
                                                }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setor">Setor da empresa</label>
                                            <input type="text" v-model="empresa.company_sector" class="form-control"
                                                id="setor" placeholder="Ex: vendas, marketing, tecnologia, etc.">
                                            <div v-if="errors.company_sector" class="text-danger">{{
                                                errors.company_sector }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputBio">Sobre</label>
                                            <textarea rows="2" v-model="empresa.about_company" class="form-control"
                                                id="inputBio"
                                                placeholder="Faça um breve resumo sobre sua empresa"></textarea>
                                            <div v-if="errors.about_company" class="text-danger">{{ errors.about_company
                                                }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="mt-2">
                                                <img class="rounded-circle mt-5" width="150px"
                                                    :src="empresa.company_photo" alt="Imagem de Perfil">

                                                <input type="file" @change="onImageChange" style="display: none;"
                                                    ref="fileInput" />
                                                <button type="button" class="btn btn-primary mt-3"
                                                    @click="triggerFileInput">Alterar Imagem</button>

                                            </div>
                                            <small>Adicione uma foto de perfil para sua empresa. Se não selecionar,
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
import NavbarEmpresa from '@/components/NavbarEmpresa.vue';
import HttpService from '../services/HttpService';
import { mapGetters } from 'vuex';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

export default {
    components: {
        NavbarEmpresa
    },
    data() {
        return {
            empresa: {
                id: '',
                company_name: '',
                company_sector: '',
                about_company: '',
                company_photo: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg',
                company_photo_file: null, // Campo para armazenar o arquivo de imagem
            },
            errors: {},
            token: localStorage.getItem('authToken') || '',
        };
    },
    created() {
        this.fetchCompany();
    },
    computed: {
        ...mapGetters(['getCompanyId']),
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
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(file.type)) {
                    this.showToast('error', 'Por favor, envie uma imagem válida.');
                    return;
                }
                this.empresa.company_photo_file = file;
                const reader = new FileReader();
                reader.onload = () => {
                    this.empresa.company_photo = reader.result;
                };
                reader.readAsDataURL(file);
            }
        },

        validateFields() {
            this.errors = {};
            if (!this.empresa.company_name) {
                this.errors.company_name = "O nome da empresa é obrigatório.";
            }
            if (!this.empresa.company_sector) {
                this.errors.company_sector = "O setor da empresa é obrigatório.";
            }
            if (!this.empresa.about_company) {
                this.errors.about_company = "O sobre da empresa é obrigatório.";
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
                    `/company/update/${this.getCompanyId}`,
                    this.empresa,
                    {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }
                );

                if (updateResponse.status !== 200) {
                    this.showToast('error', 'Erro ao atualizar as informações da empresa.');
                    return;
                }

                // Se a imagem for alterada, envia para o backend
                if (this.empresa.company_photo_file) {
                    const formData = new FormData();
                    formData.append('image', this.empresa.company_photo_file);

                    const uploadResponse = await HttpService.post(
                        '/company/upload-profile-image',
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

        async fetchCompany() {
            try {
                const response = await HttpService.get(`/company/show/${this.getCompanyId}`, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                });

                const company = response.data.company;
                this.empresa.id = company.id || '';
                this.empresa.company_name = company.company_name || '';
                this.empresa.company_sector = company.company_sector || '';
                this.empresa.about_company = company.about_company || '';

                if (company.company_photo) {
                    this.empresa.company_photo = `http://127.0.0.1:8000/storage/${company.company_photo}`;
                }
            } catch (error) {
                console.error('Erro ao carregar o perfil da empresa:', error);
                this.showToast('error', 'Erro ao carregar o perfil da empresa.');
            }
        },

        triggerFileInput() {
            this.$refs.fileInput.click();
        },
    },
    mounted() {
        this.empresa.id = this.getCompanyId;
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

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.text-center img {
    margin-bottom: 15px;
}

.list-group-item-action {
    cursor: pointer;
}

.form-group {
    margin-bottom: 30px;
}
</style>