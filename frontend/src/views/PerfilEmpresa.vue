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
                            <router-link to="/perfil-empresa"
                                class="list-group-item list-group-item-action">Empresa</router-link>
                            <router-link to="/add-recrutador" class="list-group-item list-group-item-action">Adicionar
                                Recrutador</router-link>
                            <router-link to="/recrutadores" class="list-group-item list-group-item-action">
                                Recrutadores</router-link>
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
                                        </div>
                                        <div class="form-group">
                                            <label for="setor">Setor da empresa</label>
                                            <input type="text" v-model="empresa.company_sector" class="form-control"
                                                id="setor" placeholder="Ex: vendas, marketing, tecnologia, etc.">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputBio">Sobre</label>
                                            <textarea rows="2" v-model="empresa.about_company" class="form-control"
                                                id="inputBio"
                                                placeholder="Faça um breve resumo sobre sua empresa"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <img :src="profileImagePreview || empresa.company_photo || '../../public/user.png'"
                                                alt="Imagem da Empresa" class="rounded-circle img-responsive mt-2"
                                                width="128" height="128">
                                            <div class="mt-2">
                                                <label class="btn btn-primary">
                                                    <i class="fa fa-upload"></i>
                                                    <input type="file" ref="fileInput" @change="onImageChange" hidden>
                                                </label>
                                            </div>
                                            <small>Para melhores resultados, use uma imagem de pelo menos 128px por
                                                128px em .jpg</small>
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
                company_photo: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'
            },
            profileImagePreview: '',
            errors: {},
            token: localStorage.getItem('authToken') || ''
        };
    },
    created() {
        this.fetchCompany();
    },
    computed: {
        ...mapGetters(['getCompanyId'])
    },
    methods: {
        onImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.profileImagePreview = URL.createObjectURL(file);
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
                    alert('Usuário não autenticado!');
                    return;
                }

                const response = await HttpService.put(`/company/update/${this.getCompanyId}`, this.empresa, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status == 200) {
                    alert('Informações da conta atualizadas com sucesso.');
                } else {
                    alert('Erro ao atualizar as informações da empresa.');
                }
            } catch (error) {
                console.error("Erro ao atualizar conta:", error);
                alert('Erro ao atualizar informações da conta.');
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
                        Authorization: `Bearer ${this.token}`
                    }
                });
                const user = response.data.company;
                this.empresa.id = user.id || '';
                this.empresa.company_name = user.company_name || '';
                this.empresa.company_sector = user.company_sector || '';
                this.empresa.about_company = user.about_company || '';
                this.empresa.company_photo = user.company_photo || null;
            } catch (error) {
                console.error('Erro ao carregar o perfil da empresa:', error);
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        }
    },
    mounted() {
        console.log('Company ID: ', this.getCompanyId);
        this.empresa.id = this.getCompanyId;

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
