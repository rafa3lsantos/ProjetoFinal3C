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
                                <form @submit.prevent="registerCompany">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name">Nome da Empresa</label>
                                                <input type="text" v-model="companyName" class="form-control" id="name"
                                                    placeholder="Nome da sua empresa">
                                            </div>
                                            <div class="form-group">
                                                <label for="setor">Setor da empresa</label>
                                                <input type="text" v-model="companySector" class="form-control"
                                                    id="setor" placeholder="Ex: vendas, marketing, tecnologia, etc.">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputBio">Sobre</label>
                                                <textarea rows="2" v-model="aboutCompany" class="form-control"
                                                    id="inputBio"
                                                    placeholder="Faça um breve resumo sobre sua empresa"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="João da Silva" src="../../public/user.png"
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

                    <div v-if="currentSection === 'addRecrutador'">
                        <!-- Conteúdo para adicionar recrutador, sem alterações -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarEmpresa from '@/components/NavbarEmpresa.vue';
import HttpService from '../services/HttpService';

export default {
    data() {
        return {
            currentSection: 'empresa',
            // Dados da empresa
            companyName: '',
            companySector: '',
            aboutCompany: '',
            // Dados do recrutador (sem alterações)
            name: '',
            cpf: '',
            email: '',
            birthdate: '',
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        async registerCompany() {
            const formData = new FormData();
            formData.append('name', this.companyName);
            formData.append('company_sector', this.companySector);
            formData.append('about_company', this.aboutCompany);

            try {
                const response = await HttpService.post('company/register', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                alert('Informações da empresa salvas com sucesso!');
                this.$router.push('/perfil-empresa');
            } catch (error) {
                console.error("Erro ao salvar informações da empresa:", error);
                if (error.response && error.response.data) {
                    console.error("Detalhes do erro:", error.response.data);
                }
                alert('Erro ao salvar as informações. Verifique os dados e tente novamente.');
            }
        },
        async registerRecruiter() {
            if (this.password !== this.password_confirmation) {
                alert('As senhas não coincidem!');
                return;
            }

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('cpf', this.cpf);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('birthdate', this.birthdate);

            try {
                const response = await HttpService.post('recruiter/register', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                alert('Recrutador adicionado com sucesso!');
                this.$router.push('/perfil-empresa');
            } catch (error) {
                console.error("Erro ao registrar o recrutador:", error);
                if (error.response && error.response.data) {
                    console.error("Detalhes do erro:", error.response.data);
                }
                alert('Erro ao registrar. Verifique os dados e tente novamente.');
            }
        }
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