<template>
    <div>
        <NavbarEmpresa />

        <div class="container p-0">
            <div class="row">
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
                    rel="stylesheet" />

                <div class="container mt-5 pt-4">
                    <div class="row justify-content-center align-items-center mb-5 pb-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" v-model="searchTerm"
                                placeholder="Pesquisar recrutador">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" @click="applyFilters">Filtrar</button>
                        </div>
                    </div>

                    <section class="vh-100">
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div v-for="recruiter in filteredRecruiters" :key="recruiter.id"
                                    class="col col-lg-6 mb-4 mb-lg-0">
                                    <div class="card mb-3" style="border-radius: .5rem;">
                                        <div class="row g-0">
                                            <div class="col-md-4 gradient-custom text-center text-white"
                                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                                <img :src="recruiter.photo || defaultPhoto" alt="Avatar"
                                                    class="img-fluid my-5" style="width: 150px;" />
                                                <div class="description">
                                                    <h5>{{ recruiter.name }}</h5>
                                                    <p>Recrutador</p>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body p-4">
                                                    <h6>Informações</h6>
                                                    <hr class="mt-0 mb-4">
                                                    <div class="row pt-1">
                                                        <div class="col-6 mb-3">
                                                            <h6>Email</h6>
                                                            <p class="text-muted">{{ recruiter.email }}</p>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <h6>Telefone</h6>
                                                            <p class="text-muted">{{ recruiter.phone }}</p>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-0 mb-4">
                                                    <div class="row pt-1">
                                                        <div class="col-6 mb-3">
                                                            <h6>Gênero</h6>
                                                            <p class="text-muted">{{ recruiter.gender }}</p>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <h6>Data de Nascimento</h6>
                                                            <p class="text-muted">{{ recruiter.birthdate }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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
    components: { NavbarEmpresa },
    data() {
        return {
            recruiters: [],
            filteredRecruiters: [],
            searchTerm: '',
            defaultPhoto: 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp',
        };
    },
    created() {
        this.fetchRecruiters();
    },
    computed: {
        ...mapGetters(['getAuthToken', 'getCompanyId']),
    },
    methods: {
        async fetchRecruiters() {
            try {
                const response = await HttpService.get(`/company/index-for-company`, {
                    headers: {
                        Authorization: `Bearer ${this.getAuthToken}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (response.status === 200) {
                    this.recruiters = response.data.recruiters;
                    this.filteredRecruiters = [...this.recruiters];
                } else {
                    alert('Erro ao carregar os recrutadores.');
                }
            } catch (error) {
                console.error('Erro ao carregar os recrutadores:', error);
            }
        },
        applyFilters() {
            this.filteredRecruiters = this.recruiters.filter((recruiter) =>
                recruiter.name.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },
    },
};
</script>

<style scoped>
.gradient-custom {
    background: #4facfe;
    background: -webkit-linear-gradient(to right bottom, rgba(79, 172, 254, 1), rgba(0, 102, 204, 1));
    background: linear-gradient(to right bottom, rgba(79, 172, 254, 1), rgba(0, 102, 204, 1));
}

.description {
    color: black;
}
</style>
