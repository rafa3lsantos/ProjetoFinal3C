<template>
    <div>
        <section class="vh-100" style="background-color: #cfcccc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Experiência
                                        Profissional:</h5>
                                    <form @submit.prevent="openModal">
                                        <div v-for="(experiencia, index) in experiencias" :key="index">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="empresa">Empresa</label>
                                                    <input type="text" class="form-control" id="empresa"
                                                        v-model="experiencia.empresa"
                                                        placeholder="Digite o nome da empresa" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="cargo">Cargo</label>
                                                        <input type="text" class="form-control" id="cargo"
                                                            v-model="experiencia.cargo" placeholder="Cargo que exercia"
                                                            required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Meu emprego Atual</label>
                                                    <div class="genero-options py-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                v-model="experiencia.empregoAtual">
                                                            <label class="form-check-label">Emprego Atual</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inicio">Início</label>
                                                    <input type="date" class="form-control" v-model="experiencia.inicio"
                                                        id="inicio" required>
                                                </div>
                                            </div>
                                            <div v-if="!experiencia.empregoAtual" class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="fim">Fim</label>
                                                    <input type="date" class="form-control" v-model="experiencia.fim"
                                                        id="fim">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="descricao">Descrição das atividades</label>
                                                    <textarea class="form-control" id="descricao"
                                                        v-model="experiencia.descricao" rows="4"
                                                        placeholder="Descreva as atividades..." required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="save btn btn-primary">Salvar Informações</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja adicionar mais vagas?</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você deseja adicionar mais experiências profissionais ou prosseguir?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="addAnotherExperience">Adicionar outra
                            experiência</button>
                        <button type="button" class="btn btn-primary" @click="proceed">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import HttpService from '../services/HttpService';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { useRouter } from 'vue-router';
export default {
    data() {
        return {
            experiencias: [{
                empresa: '',
                cargo: '',
                empregoAtual: false,
                inicio: '',
                fim: '',
                descricao: ''
            }],
            token: localStorage.getItem('authToken') || '',
            showModal: false,
        };
    },

    methods: {

        openModal() {
            this.showModal = true;
        },

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

        closeModal() {
            this.showModal = false;
        },


        async addAnotherExperience() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const experiencia = this.experiencias[0];
                const response = await HttpService.post('/experience/register', {
                    company: experiencia.empresa,
                    position: experiencia.cargo,
                    start_date_work: experiencia.inicio,
                    end_date_work: experiencia.empregoAtual ? null : experiencia.fim,
                    is_currently_working: experiencia.empregoAtual,
                    description_ativities: experiencia.descricao,
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200) {
                    this.showToast('success', 'Experiência profissional registrada com sucesso.');


                    this.experiencias = [{
                        empresa: '',
                        cargo: '',
                        empregoAtual: false,
                        inicio: '',
                        fim: '',
                        descricao: ''
                    }];
                    this.closeModal();
                } else {
                    this.showToast('error', 'Erro ao registrar experiência profissional.');
                }
            } catch (error) {
                this.showToast('error', 'Erro ao registrar experiência profissional.');
            }
        },


        async proceed() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const experiencia = this.experiencias[0];
                const response = await HttpService.post('/experience/register', {
                    company: experiencia.empresa,
                    position: experiencia.cargo,
                    start_date_work: experiencia.inicio,
                    end_date_work: experiencia.empregoAtual ? null : experiencia.fim,
                    is_currently_working: experiencia.empregoAtual,
                    description_ativities: experiencia.descricao,
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200) {
                    this.showToast('success', 'Experiência profissional registrada com sucesso.');
                    this.$router.push('/formacao');
                } else {
                    this.showToast('error', 'Erro ao registrar experiência profissional.');
                }
            } catch (error) {
                this.showToast('error', 'Erro ao registrar experiência profissional.');
            }
        },
    }
}
</script>


<style scoped>
body {
    margin-top: 20px;
    background-color: #cfcccc;
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
}

</style>
