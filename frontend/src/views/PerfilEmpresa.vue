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
                            <a class="list-group-item list-group-item-action"
                                @click="showSection('empresa')">Empresa</a>
                            <a class="list-group-item list-group-item-action"
                                @click="showSection('addRecrutador')">Adicionar Recrutador</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div v-if="currentSection === 'empresa'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Empresa</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="updateCompany">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name">Nome da Empresa</label>
                                                <input type="text" v-model="company_name" class="form-control" id="name"
                                                    placeholder="Nome da sua empresa" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="setor">Setor da empresa</label>
                                                <input type="text" v-model="company_sector" class="form-control"
                                                    id="setor" placeholder="Ex: vendas, marketing, tecnologia, etc.">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputBio">Sobre</label>
                                                <textarea rows="2" v-model="about_company" class="form-control"
                                                    id="inputBio"
                                                    placeholder="Faça um breve resumo sobre sua empresa"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img :src="company_photoPreview || company_photoUrl || '../../public/user.png'"
                                                    alt="Imagem da Empresa" class="rounded-circle img-responsive mt-2"
                                                    width="128" height="128">
                                                <div class="mt-2">
                                                    <label class="btn btn-primary">
                                                        <i class="fa fa-upload"></i>
                                                        <input type="file" @change="handleCompanyPhotoUpload" hidden>
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

                    <div v-if="currentSection === 'addRecrutador'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Adicionar Recrutador</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="registerRecruiter" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name">Nome do Recrutador</label>
                                                <input type="text" v-model="name" class="form-control" required
                                                    placeholder="Nome do Recrutador">
                                            </div>
                                            <div class="form-group">
                                                <label for="birthdate">Data de Nascimento</label>
                                                <input type="date" class="form-control" id="dataNascimento" required
                                                    v-model="birthdate">
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf">CPF</label>
                                                <input type="text" v-model="cpf" class="form-control" required
                                                    placeholder="CPF do Recrutador">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" v-model="email" class="form-control" required
                                                    placeholder="Email para o login">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Crie uma Senha</label>
                                                <input type="password" v-model="password" class="form-control" required
                                                    placeholder="Senha para o login">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirme a senha</label>
                                                <input type="password" v-model="password_confirmation"
                                                    class="form-control" required placeholder="Confirme a senha">
                                            </div>
                                            <div class="form-group">
                                                <label for="company_id">Selecione a Empresa</label>
                                                <select v-model="companyId" class="form-control" required>
                                                    <option value="" disabled selected>Selecione uma empresa</option>
                                                    <option v-for="company in companies" :value="company.id"
                                                        :key="company.id">
                                                        {{ company.company_name }}
                                                    </option>
                                                </select>
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
                                                        <input type="file" @change="handleFileUpload" hidden>
                                                    </label>
                                                </div>
                                                <small>Adicione uma foto de perfil para seu recrutador. Se não
                                                    selecionar, será usada a imagem padrão.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Adicionar Recrutador</button>
                                </form>
                            </div>
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
            currentSection: 'empresa',
            company_name: '',
            company_sector: '',
            about_company: '',
            company_photo: null,
            company_photoPreview: '',
            company_photoUrl: '',

            name: '',
            cpf: '',
            email: '',
            birthdate: '',
            password: '',
            password_confirmation: '',
            profileImage: null,
            profileImagePreview: '',
            companyId: '',
            companies: []
        };
    },
    computed: {
        ...mapGetters(['getCompanyId']),
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.profileImage = file;
            this.profileImagePreview = URL.createObjectURL(file);
        },
        handleCompanyPhotoUpload(event) {
            const file = event.target.files[0];
            this.company_photo = file;
            this.company_photoPreview = URL.createObjectURL(file);
        },
        async fetchCompanies() {
            try {
                const response = await HttpService.get('company/show');
                this.companies = response.data;
            } catch (error) {
                console.error("Erro ao carregar empresas:", error);
            }
        },
        async fetchCompanyDetails() {
            try {
                const response = await HttpService.get(`company/show/${this.getCompanyId}`);
                const company = response.data;
                this.company_name = company.company_name;
                this.company_sector = company.company_sector;
                this.about_company = company.about_company;
                this.company_photoUrl = company.company_photo;
            } catch (error) {
                console.error("Erro ao carregar detalhes da empresa:", error);
            }
        },
        async updateCompany() {
            if (!this.getCompanyId) {
                alert("Erro: ID da empresa não está disponível.");
                return;
            }


            let data = {
                company_name: this.company_name,
                company_sector: this.company_sector,
                about_company: this.about_company,
                company_photo: this.company_photo || null,
            };

            try {
                const token = localStorage.getItem('authToken');
                if (!token) {
                    alert('Usuário não autenticado!');
                    return;
                }


                if (this.company_photo) {
                    const photoData = new FormData();
                    photoData.append('company_photo', this.company_photo);


                    const photoResponse = await HttpService.post('company/upload-photo', photoData, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'multipart/form-data',
                        }
                    });

                    if (photoResponse.data.success) {
                        data.company_photo = photoResponse.data.photo_url;
                    } else {
                        alert('Erro ao fazer upload da foto');
                        return;
                    }
                }

                const response = await HttpService.put(`company/update/${this.getCompanyId}`, data, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    }
                });

                if (response.data.success) {
                    alert('Informações da empresa atualizadas com sucesso!');
                } else {
                    alert('Erro ao atualizar as informações da empresa.');
                }
            } catch (error) {
                console.error("Erro ao atualizar informações da empresa:", error);
                alert('Erro ao atualizar informações da empresa.');
            }
        },



        async registerRecruiter() {
            if (this.password !== this.password_confirmation) {
                alert('As senhas não coincidem!');
                return;
            }

            if (!this.name || !this.cpf || !this.email || !this.password || !this.birthdate || !this.companyId) {
                alert('Por favor, preencha todos os campos obrigatórios!');
                return;
            }

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('cpf', this.cpf);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('birthdate', this.birthdate);
            formData.append('company_id', this.companyId);
            if (this.profileImage) {
                formData.append('photo', this.profileImage);
            }

            try {
                const response = await HttpService.post('recruiter/register', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                if (response.data.success) {
                    alert('Recrutador adicionado com sucesso!');
                    this.name = '';
                    this.cpf = '';
                    this.email = '';
                    this.password = '';
                    this.password_confirmation = '';
                    this.birthdate = '';
                    this.companyId = '';
                    this.profileImage = null;
                    this.profileImagePreview = '';
                    this.$router.push('/perfil-empresa');
                } else {
                    alert('Erro ao cadastrar recrutador, tente novamente.');
                }
            } catch (error) {
                console.error("Erro ao registrar o recrutador:", error);
                alert('Erro ao cadastrar recrutador, tente novamente.');
            }
        }
    },
    mounted() {
        this.fetchCompanies();
        this.fetchCompanyDetails();
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
