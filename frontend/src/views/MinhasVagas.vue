<template>
    <div>
        <NavbarRecrutador />

        <div class="container p-0">
            <div class="row">
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
                    rel="stylesheet" />

                <div class="container mt-5 pt-4">
                    <div class="row align-items-end mb-4 pb-2">
                        <div class="col-md-8">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2" v-for="(vaga, index) in vagas" :key="index">
                            <div class="card border-0 bg-light rounded shadow">
                                <div class="card-body p-4">
                                    <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">
                                        {{ vaga.work_model === 'remote' ? 'Remoto' : 'Presencial' }}
                                    </span>
                                    <h5>{{ vaga.title }}</h5>
                                    <div class="mt-3">
                                        <span class="text-muted d-block"><i class="fa fa-building"
                                                aria-hidden="true"></i>
                                            <a href="#" target="_blank" class="text-muted"> {{
                                                 empresa.company_name }}</a></span>
                                        <span class="text-muted d-block"><i class="fa fa-briefcase"
                                                aria-hidden="true"></i>
                                            <a href="#" target="_blank" class="text-muted"> {{ vaga.job_type
                                                }}</a></span>
                                        <span class="text-muted d-block"><i class="fa fa-map-marker"
                                                aria-hidden="true"></i>
                                            {{ vaga.jobs_city }} - {{ vaga.jobs_state }}</span>
                                        <p>{{ vaga.jobs_description }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <a href="#" class="btn btn-primary">Editar</a>
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
            companies: {},
            empresa: {
                id: '',
                company_name: '',
                company_sector: '',
                about_company: '',
                // company_photo: 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'
            },
        };
    },
    created() {
        this.fetchVagas(),
            this.fetchCompany();
    },
    computed: {
        ...mapGetters(['getAuthToken', 'getRecruiterId', 'getCompanyId'])
    },
    methods: {
        // Método para buscar as vagas e associar os nomes das empresas
        async fetchVagas() {
            try {
                const response = await HttpService.get('/jobs/show', {
                    headers: {
                        Authorization: `Bearer ${this.getAuthToken}`,
                        'Content-Type': 'application/json'
                    }
                });
                console.log('Vagas carregadas:', response.data.jobs);

                if (response.status === 200) {
                    this.vagas = response.data.jobs;

                    // Buscar os nomes das empresas associadas às vagas
                    const companyIds = [...new Set(this.vagas.map(vaga => vaga.company_id))];
                    for (let companyId of companyIds) {
                        await this.fetchCompanyName(companyId);
                    }
                } else {
                    alert('Erro ao carregar as vagas.');
                }
            } catch (error) {
                console.error('Erro ao buscar vagas:', error);
                alert('Erro ao buscar vagas.');
            }
        },

        // Método para buscar o nome da empresa com base no company_id
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
                // this.empresa.company_photo = user.company_photo || null;
            } catch (error) {
                console.error('Erro ao carregar o perfil da empresa:', error);
            }
        },
    },
    mounted() {
        this.empresa.id = this.getCompanyId;
    }
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

.bg-primary,
.btn-primary,
.btn-outline-primary:hover,
.btn-outline-primary:focus,
.btn-outline-primary:active,
.btn-outline-primary.active,
.btn-outline-primary.focus,
.btn-outline-primary:not(:disabled):not(.disabled):active,
.badge-primary,
.nav-pills .nav-link.active,
.pagination .active a,
.custom-control-input:checked~.custom-control-label:before,
#preloader #status .spinner>div,
.social-icon li a:hover,
.back-to-top:hover,
.back-to-home a,
::selection,
#topnav .navbar-toggle.open span:hover,
.owl-theme .owl-dots .owl-dot.active span,
.owl-theme .owl-dots.clickable .owl-dot:hover span,
.watch-video a .play-icon-circle,
.sidebar .widget .tagcloud>a:hover,
.flatpickr-day.selected,
.flatpickr-day.selected:hover,
.tns-nav button.tns-nav-active,
.form-check-input.form-check-input:checked {
    background-color: #6dc77a !important;
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

.btn-primary {
    background-color: #6dc77a !important;
    border: 1px solid #6dc77a !important;
    color: #fff !important;
    box-shadow: 0 3px 7px rgb(109 199 122 / 50%);
}

a {
    text-decoration: none;
}
</style>
