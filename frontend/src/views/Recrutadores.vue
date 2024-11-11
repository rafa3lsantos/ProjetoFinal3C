<template>
    <div>
        <NavbarEmpresa />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <a class="list-group-item list-group-item-action" @click="showSection('conta')">
                                Conta
                            </a>
                            <a class="list-group-item list-group-item-action" @click="showSection('dataNascimento')">
                                Data de Nascimento
                            </a>
                            <a class="list-group-item list-group-item-action" @click="showSection('email')">
                                Email
                            </a>
                            <a class="list-group-item list-group-item-action" @click="showSection('senha')">
                                Senha
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-xl-8">
                    <div v-if="currentSection === 'conta'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Conta</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="inputUsername">Nome Completo</label>
                                                <input type="text" class="form-control" id="inputUsername"
                                                    placeholder="Username">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputUsername">Sobre você</label>
                                                <textarea rows="2" class="form-control" id="inputBio"
                                                    placeholder="Faça um breve resumo sobre você"></textarea>
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

                    <div v-if="currentSection === 'dataNascimento'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Data de Nascimento</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="salvarDataNascimento">
                                    <div class="form-group">
                                        <label for="dataNascimento">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="dataNascimento"
                                            v-model="usuario.dataNascimento">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentSection === 'email'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Email</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="salvarEmail">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" v-model="usuario.email"
                                            placeholder="Email">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div v-if="currentSection === 'senha'">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Alterar Senha</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="salvarSenha">
                                    <div class="form-group">
                                        <label for="senhaAtual">Senha Atual</label>
                                        <input type="password" class="form-control" id="senhaAtual" v-model="senhaAtual"
                                            placeholder="Digite sua senha atual">
                                    </div>
                                    <div class="form-group">
                                        <label for="novaSenha">Nova Senha</label>
                                        <input type="password" class="form-control" id="novaSenha" v-model="novaSenha"
                                            placeholder="Digite a nova senha">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmarSenha">Confirmar Nova Senha</label>
                                        <input type="password" class="form-control" id="confirmarSenha"
                                            v-model="confirmarSenha" placeholder="Confirme a nova senha">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Aterar Senha</button>
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

export default {
    data() {
        return {
            currentSection: 'conta',
            usuario: {
                nome: '',
                dataNascimento: '',
                email: '',
                fotoPerfil: null,
            },
            senhaAtual: '',
            novaSenha: '',
            confirmarSenha: '',
        };
    },
    methods: {
        showSection(section) {
            this.currentSection = section;
        },
        salvarConta() {
            alert('Informações da conta salvas com sucesso!');
        },
        trocarFotoPerfil(event) {
            const file = event.target.files[0];
            if (file) {
                this.usuario.fotoPerfil = URL.createObjectURL(file);
            }
        },
        salvarDataNascimento() {
            alert('Data de nascimento salva com sucesso!');
        },
        salvarEmail() {
            alert('Email salvo com sucesso!');
        },
        salvarSenha() {
            if (this.novaSenha !== this.confirmarSenha) {
                alert('As senhas não correspondem!');
                return;
            }
            alert('Senha alterada com sucesso!');
        },
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