<template>
    <div>
        <NavbarRecrutador />

        <div class="container p-0">
            <div class="row">
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
                    rel="stylesheet" />

                <div class="container mt-5 pt-4">
                    <div class="row align-items-end mb-4 pb-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" v-model="searchTerm"
                                placeholder="Pesquisar por título ou descrição">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" v-model="selectedWorkModel">
                                <option value="">Modelo de Trabalho</option>
                                <option value="remote">Remoto</option>
                                <option value="presential">Presencial</option>
                                <option value="hybrid">Híbrido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" v-model="selectedJobType">
                                <option value="">Tipo de Trabalho</option>
                                <option value="effective">Efetivo</option>
                                <option value="freelancer">Freelancer</option>
                                <option value="temporary">Temporário</option>
                                <option value="internship">Estágio</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" v-model="selectedJobStatus">
                                <option value="">Status</option>
                                <option value="in_progress">Em andamento</option>
                                <option value="under_review">Em análise</option>
                                <option value="finished">Finalizada</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" @click="applyFilters">Filtrar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 mt-4 pt-2" v-for="(vaga, index) in filteredVagas"
                            :key="index">
                            <div class="card border-0 bg-light rounded shadow">
                                <div class="card-body p-4">
                                    <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">
                                        {{ translateWorkModel(vaga.work_model) }}
                                    </span>
                                    <span class="badge rounded-pill bg-secondary float-md-end mb-3 mb-sm-0">
                                        {{ translateJobStatus(vaga.jobs_status) }}
                                    </span>
                                    <h5>{{ vaga.title }}</h5>
                                    <div class="mt-3">
                                        <span class="text-muted d-block"><i class="fa fa-building"
                                                aria-hidden="true"></i>
                                            <a href="#" target="_blank" class="text-muted"> {{ empresa.company_name
                                                }}</a></span>
                                        <span class="text-muted d-block"><i class="fa fa-briefcase"
                                                aria-hidden="true"></i>
                                            <a href="#" target="_blank" class="text-muted"> {{
                                                translateWorktype(vaga.job_type) }}</a></span>
                                        <span class="text-muted d-block"><i class="fa fa-map-marker"
                                                aria-hidden="true"></i>
                                            {{ vaga.jobs_city }} - {{ vaga.jobs_state }}</span>
                                        <p>{{ truncateDescription(vaga.jobs_description) }}</p>
                                    </div>
                                    <div class="mt-3">
                                        <a  href="#" class="btn btn-primary"
                                            @click="editVaga(vaga)">Editar</a>
                                    </div>
                                </div>
                            </div>
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

export default {
    components: { NavbarRecrutador },
    data() {
        return {
            vagas: [],
            filteredVagas: [],
            companies: {},
            empresa: {
                id: '',
                company_name: '',
                company_sector: '',
                about_company: '',
            },
            searchTerm: '',
            selectedWorkModel: '',
            selectedJobType: '',
            selectedJobStatus: '',
        };
    },
    created() {
        this.fetchVagas();
        this.fetchCompany();
    },
    computed: {
        ...mapGetters(['getAuthToken', 'getRecruiterId', 'getCompanyId'])
    },
    methods: {
        translateWorkModel(model) {
            const translations = {
                remote: 'Remoto',
                presential: 'Presencial',
                hybrid: 'Híbrido',
            };
            return translations[model] || 'Modelo Desconhecido';
        },

        translateWorktype(model) {
            const translations = {
                effective: 'Efetivo',
                freelancer: 'Freelancer',
                temporary: 'Temporário',
                internship: 'Estágio',
            };
            return translations[model] || 'Tipo Desconhecido';
        },

        translateJobStatus(status) {
            const translations = {
                in_progress: 'Em andamento',
                under_review: 'Em análise',
                finished: 'Finalizada',
            };
            return translations[status] || 'Status Desconhecido';
        },

        truncateDescription(description, limit = 200) {
            if (!description) return '';
            return description.length > limit
                ? description.substring(0, limit) + '...'
                : description;
        },

        async fetchVagas() {
            try {
                const response = await HttpService.get('/jobs/index', {
                    headers: {
                        Authorization: `Bearer ${this.getAuthToken}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200) {
                    this.vagas = response.data.jobs;

   
                    this.filteredVagas = [...this.vagas];
                } else {
                    alert('Erro ao carregar as vagas.');
                }
            } catch (error) {
                console.error('Erro ao carregar as vagas:', error);
            }
        },

        async fetchCompany() {
            try {
                const response = await HttpService.get(`/company/show/${this.getCompanyId}`, {
                    headers: {
                        Authorization: `Bearer ${this.getAuthToken}`
                    }
                });
                const user = response.data.company;
                this.empresa.id = user.id || '';
                this.empresa.company_name = user.company_name || '';
                this.empresa.company_sector = user.company_sector || '';
                this.empresa.about_company = user.about_company || '';
            } catch (error) {
                console.error('Erro ao carregar o perfil da empresa:', error);
            }
        },

        applyFilters() {
            this.filteredVagas = this.vagas.filter(vaga => {
                const matchesSearchTerm = this.searchTerm
                    ? vaga.title.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                    vaga.jobs_description.toLowerCase().includes(this.searchTerm.toLowerCase())
                    : true;

                const matchesWorkModel = this.selectedWorkModel
                    ? vaga.work_model === this.selectedWorkModel
                    : true;

                const matchesJobType = this.selectedJobType
                    ? vaga.job_type === this.selectedJobType
                    : true;

                const matchesJobStatus = this.selectedJobStatus
                    ? vaga.jobs_status === this.selectedJobStatus
                    : true;

                return matchesSearchTerm && matchesWorkModel && matchesJobType && matchesJobStatus;
            });
        },

        editVaga(vaga) {
            this.$router.push({
                name: 'UpdateVaga',
                params: { id: vaga.id },
            });
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
}

.shadow {
    box-shadow: 0 0 3px rgb(53 64 78 / 20%) !important;
}

.rounded {
    border-radius: 5px !important;
}

.bg-light {
    background-color: #f7f8fa !important;
}

.btn {
    padding: 8px 20px;
    outline: none;
    text-decoration: none;
    font-size: 16px;
    letter-spacing: 0.5px;
    transition: all 0.3s;
    font-weight: 600;
    border-radius: 5px;
}

a {
    text-decoration: none;
}

.badge {
    margin-right: 10px;
}

i{
    margin-right:5px;
}

.card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 300px;
}
</style>
