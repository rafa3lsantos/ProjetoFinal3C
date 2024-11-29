<template>
    <div>
        <section class="vh-100" style="background-color: #cfcccc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Habilidades:</h5>
                                    <form @submit.prevent="registerSkills">
                                        <div class="form-group">
                                            <label for="softSkills">Soft Skills</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" v-model="newSoftSkill"
                                                    placeholder="Adicione uma soft skill">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button"
                                                        @click="addSoftSkill">Adicionar</button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <span v-for="(skill, index) in softSkills" :key="index"
                                                    class="badge skill-badge mr-1">
                                                    {{ skill }} <button type="button" class="close"
                                                        @click="removeSoftSkill(index)">&times;</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hardSkills">Hard Skills</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" v-model="newHardSkill"
                                                    placeholder="Adicione uma hard skill">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button"
                                                        @click="addHardSkill">Adicionar</button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <span v-for="(skill, index) in hardSkills" :key="index"
                                                    class="badge skill-badge mr-1">
                                                    {{ skill }} <button type="button" class="close"
                                                        @click="removeHardSkill(index)">&times;</button>
                                                </span>
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
    </div>
</template>




<script>
import HttpService from '../services/HttpService';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            newSoftSkill: '',
            newHardSkill: '',
            softSkills: [],
            hardSkills: [],
            token: localStorage.getItem('authToken') || '',
            showModal: false,
        };
    },

    computed: {
        ...mapGetters(['getCandidateId'])
    },

    methods: {

        addSoftSkill() {
            if (this.newSoftSkill.trim() !== '') {
                this.softSkills.push(this.newSoftSkill);
                this.newSoftSkill = '';
            }
        },

        removeSoftSkill(index) {
            this.softSkills.splice(index, 1);
        },


        addHardSkill() {
            if (this.newHardSkill.trim() !== '') {
                this.hardSkills.push(this.newHardSkill);
                this.newHardSkill = '';
            }
        },


        removeHardSkill(index) {
            this.hardSkills.splice(index, 1);
        },

        async registerSkills() {
            try {
                if (!this.token) {
                    this.showToast('error', 'Usuário não autenticado!');
                    return;
                }

                const data = {
                    soft_skills: this.softSkills,
                    hard_skills: this.hardSkills,
                };

                const response = await HttpService.post('/skills/store', data, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 201) {
                    this.showToast('success', 'Skills registradas com sucesso.');
                    this.$router.push('/idioma');
                } else {
                    this.showToast('error', 'Erro ao registrar skills.');
                }
            } catch (error) {
                this.showToast('error', 'Erro ao registrar skills.');
            }
        },




        showToast(type, message) {
            let backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
            Toastify({
                text: message,
                duration: 1000,
                close: true,
                gravity: 'top',
                position: 'right',
                backgroundColor: backgroundColor,
            }).showToast();
        }
    }
};
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

.nota {
    font-size: 12px;
    font-style: italic;
}

.badge {
    color: black;
}
</style>
