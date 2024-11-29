<template>
    <div>
        <NavbarRecrutador />
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <input type="text" class="form-control" v-model="searchTerm" placeholder="Pesquisar candidatos"
                        style="height: 50px;" />
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


                        <div v-if="isLoading" class="text-center w-100 mt-5">
                            <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
                        </div>


                        <div v-if="!isLoading && filteredCandidates.length === 0" class="text-center w-100 mt-5">
                            <p>Nenhum candidato encontrado.</p>
                        </div>


                        <div v-for="(candidate, index) in filteredCandidates" :key="candidate.id"
                            class="espaco col-12 col-md-6 mb-4">
                            <div class="card shadow-sm" style="border-radius: .5rem;">
                                <div class="row g-0">
                                    <div class="col-12 col-md-4 gradient-custom text-center text-white"
                                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                        <img :src="`http://localhost:8000/storage/${candidate.photo}` || defaultPhoto"
                                            alt="Avatar" class="img-fluid rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover; margin-top: 20px;" />

                                        <h5 class="mt-3">{{ candidate.name_candidate }}</h5>
                                        <p>{{ candidate.cpf }}</p>
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <div class="card-body p-4">
                                            <h6>Informações</h6>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Email</h6>
                                                    <p class="text-muted">{{ candidate.email }}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Telefone</h6>
                                                    <p class="text-muted">{{ candidate.phone || 'Não informado' }}</p>
                                                </div>
                                            </div>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Gênero</h6>
                                                    <p class="text-muted">{{candidate.gender }}</p>

                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Data de Nascimento</h6>
                                                    <p class="text-muted">{{ formatDate(candidate.birthdate) }}</p>
                                                </div>

                                                <button class="btn btn-secondary w-30" @click="verCurriculo(candidate)">Ver Currículo</button>
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
import NavbarRecrutador from "@/components/NavbarRecrutador.vue";
import HttpService from "../services/HttpService";
import { mapGetters } from "vuex";

export default {
    components: { NavbarRecrutador },
    data() {
        return {
            candidates: [],
            filteredCandidates: [],
            searchTerm: "",
            defaultPhoto: "https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg",
            isLoading: false,
        };
    },
    created() {
        this.fetchCandidates();
    },
    computed: {
        ...mapGetters(["getAuthToken", "getCompanyId"]),
    },
    methods: {
        async fetchCandidates() {
            try {
                const jobId = this.$route.params.id;
                const token = this.getAuthToken;

                const response = await HttpService.get(`/applications/viewCandidates/${jobId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                if (response.status === 200) {
                    this.candidates = response.data.candidates;
                    this.filteredCandidates = [...this.candidates];


                    console.log("Candidatos recebidos:", this.candidates);
                }
            } catch (error) {
                console.error("Erro ao carregar os candidatos:", error);
            }
        },

        applyFilters() {
            this.filteredCandidates = this.candidates.filter((candidate) =>
                candidate.name.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },

        translateGender(gender) {
            const genderMap = {
                male: "Masculino",
                female: "Feminino",
                "non-binary": "Não binário",
                other: "Outro",
                "prefer not to say": "Prefiro não dizer",
                Masculino: "Masculino",
                Feminino: "Feminino"
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
