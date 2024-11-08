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
                    <!-- Seção da Empresa -->
                    <div v-if="currentSection === 'empresa'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Empresa</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name">Nome da Empresa</label>
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Nome da sua empresa">
                                            </div>
                                            <div class="form-group">
                                                <label for="setor">Setor da empresa</label>
                                                <input type="text" class="form-control" id="setor"
                                                    placeholder="Ex: vendas, marketing, tecnologia, etc.">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputUsername">Sobre</label>
                                                <textarea rows="2" class="form-control" id="inputBio"
                                                    placeholder="Faça um breve resumo sobre sua empresa"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="Imagem da Empresa" src="../../public/user.png"
                                                    class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"><i class="fa fa-upload"></i></span>
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

                    <!-- Seção para Adicionar Recrutador -->
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
                                                    <option v-for="company in companies" :value="company.id"
                                                        :key="company.id">
                                                        {{ company.name }}
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
import { mapState } from 'vuex';

export default {
    data() {
        return {
            currentSection: 'empresa', // Começa na seção "empresa"
            name: '',
            cpf: '',
            email: '',
            birthdate: '',
            password: '',
            password_confirmation: '',
            profileImage: null,
            profileImagePreview: null,
            companyId: null,
            companies: [] // Lista de empresas
        };
    },
    computed: {
        ...mapState(['user'])
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
        async fetchCompanies() {
            try {
                const response = await HttpService.get('company/show');
                this.companies = response.data;
            } catch (error) {
                console.error("Erro ao carregar empresas:", error);
                alert('Erro ao carregar empresas.');
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
                formData.append('profile_image', this.profileImage);
            }

            try {
                const response = await HttpService.post('recruiter/register', formData);
                alert('Recrutador registrado com sucesso!');
            } catch (error) {
                console.error("Erro ao registrar recrutador:", error);
                alert('Erro ao registrar recrutador.');
            }
        }
    },
    mounted() {
        this.fetchCompanies();
    },
    components: {
        NavbarEmpresa
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
    color: #fff;
    background: #4e73df;
    border-bottom: 1px solid rgba(0, 0, 0, .125);
}

.card-body {
    padding: 1.25rem;
}

.navbar {
    margin-bottom: 20px;
}
</style>



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