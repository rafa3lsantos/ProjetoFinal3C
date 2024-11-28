<template>
    <div>
        <NavbarEmpresa />

        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <input
                        type="text"
                        class="form-control"
                        v-model="searchTerm"
                        placeholder="Pesquisar recrutador"
                        style="height: 50px;"
                    />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" @click="applyFilters" style="height: 50px;">
                        Filtrar
                    </button>
                </div>
            </div>

            <section class="mt-4">
                <div class="container">
                    <div class="row">

                        <!-- Loader -->
                        <div v-if="isLoading" class="text-center w-100 mt-5">
                            <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
                        </div>

                        <!-- No Results -->
                        <div v-if="!isLoading && filteredRecruiters.length === 0" class="text-center w-100 mt-5">
                            <p>Nenhum recrutador encontrado.</p>
                        </div>

                        <!-- Cards de recrutadores em 2 colunas -->
                        <div v-for="(recruiter, index) in filteredRecruiters" :key="recruiter.id" class="espaco col-12 col-md-6 mb-4">
                            <div class="card shadow-sm" style="border-radius: .5rem;">
                                <div class="row g-0">
                                    <div class="col-12 col-md-4 gradient-custom text-center text-white"
                                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                        <img :src="recruiter.profile_image || defaultPhoto" alt="Avatar"
                                            class="img-fluid rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover; margin-top: 20px;" />
                                        <h5 class="mt-3">{{ recruiter.name }}</h5>
                                        <p>{{ recruiter.cpf }}</p>
                                    </div>

                                    <div class="col-12 col-md-8">
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
                                                    <p class="text-muted">{{ recruiter.phone || 'Não informado' }}</p>
                                                </div>
                                            </div>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Gênero</h6>
                                                    <p class="text-muted">{{ translateGender(recruiter.gender) }}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Data de Nascimento</h6>
                                                    <p class="text-muted">{{ formatDate(recruiter.birthdate) }}</p>
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
</template>

<script>
import NavbarEmpresa from "@/components/NavbarEmpresa.vue";
import HttpService from "../services/HttpService";
import { mapGetters } from "vuex";

export default {
    components: { NavbarEmpresa },
    data() {
        return {
            recruiters: [],
            filteredRecruiters: [],
            searchTerm: "",
            defaultPhoto: "https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg",
            isLoading: false,
        };
    },
    created() {
        this.fetchRecruiters();
    },
    computed: {
        ...mapGetters(["getAuthToken", "getCompanyId"]),
    },
    methods: {
        async fetchRecruiters() {
            try {
                const token = this.getAuthToken;

                const response = await HttpService.get("/company/index-for-company", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                if (response.status === 200) {
                    this.recruiters = response.data.recruiters;
                    this.filteredRecruiters = [...this.recruiters];
                }
            } catch (error) {
                console.error("Erro ao carregar os recrutadores:", error);
            }
        },

        applyFilters() {
            this.filteredRecruiters = this.recruiters.filter((recruiter) =>
                recruiter.name.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },

        translateGender(gender) {
            const genderMap = {
                male: "Masculino",
                female: "Feminino",
                "non-binary": "Não binário",
                other: "Outro",
                "prefer not to say": "Prefiro não dizer"
            };
            return genderMap[gender] || "Não informado";
        },


        formatDate(date) {
            if (!date) return 'Não informado';
            const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            return new Date(date).toLocaleDateString('pt-BR', options);
        }
    },
};
</script>

<style scoped>
.gradient-custom {
    background: #4facfe;
    background: -webkit-linear-gradient(to right bottom, rgba(79, 172, 254, 1), rgba(0, 102, 204, 1));
    background: linear-gradient(to right bottom, rgba(79, 172, 254, 1), rgba(0, 102, 204, 1));
    color: white;
}

.card {
    overflow: hidden;
}

.rounded-circle {
    border: 2px solid white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.espaco {
    margin-top: 30px;
}
</style>
