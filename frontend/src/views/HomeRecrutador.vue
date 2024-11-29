<template>
  <div>
    <NavbarRecrutador />
    <div class="container p-0">
      <div class="row">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container mt-5 pt-4">
          <div class="row align-items-end justify-content-center mb-4 pb-2">
            <div class="col-md-6">
              <input type="text" class="form-control" v-model="searchTerm"
                placeholder="vaga, cidade, palavra-chave ou empresa" />
            </div>

            <div class="col-md-2">
              <button class="btn btn-primary w-100" @click="applyFilters">Filtrar</button>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mt-4 pt-2" v-for="(vaga, index) in filteredVagas" :key="index">
              <div class="card border-0 bg-light rounded shadow">
                <div class="card-body p-4">
                  <span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">
                    {{ translateWorkModel(vaga.work_model) }}
                  </span>
                  <h5>{{ vaga.title }}</h5>
                  <div class="mt-3">
                    <span class="text-muted d-block">
                      <i class="fa fa-building" aria-hidden="true"></i>
                      <a href="#" target="_blank" class="text-muted">{{ vaga.company_name }}</a>
                    </span>
                    <span class="text-muted d-block">
                      <i class="fa fa-briefcase" aria-hidden="true"></i>
                      {{ translateWorktype(vaga.job_type) }}
                    </span>
                    <span class="text-muted d-block">
                      <i class="fa fa-map-marker" aria-hidden="true"></i>
                      {{ vaga.jobs_city }} - {{ vaga.jobs_state }}
                    </span>

                    <p>{{ truncateDescription(vaga.jobs_description) }}</p>

                  </div>
                  <div class="mt-3">
                    <button @click="viewVaga(vaga)" class="btn btn-primary">Ver Vaga</button>
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
  name: 'HomeRecrutador',
  components: {
    NavbarRecrutador,
  },
  data() {
    return {
      vagas: [],
      filteredVagas: [],
      searchTerm: '',
      selectedWorkModel: '',
      selectedJobType: '',
    };
  },
  created() {
    this.fetchVagas();
  },
  computed: {
    ...mapGetters(['getAuthToken']),
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
    translateWorktype(type) {
      const translations = {
        effective: 'Efetivo',
        freelancer: 'Freelancer',
        temporary: 'Temporário',
        internship: 'Estágio',
      };
      return translations[type] || 'Tipo Desconhecido';
    },
    truncateDescription(description, limit = 200) {
      if (!description) return '';
      return description.length > limit
        ? description.substring(0, limit) + '...'
        : description;
    },
    async fetchVagas() {
      try {
        const response = await HttpService.get('jobs/InProgress', {
          headers: {
            Authorization: `Bearer ${this.getAuthToken}`,
            'Content-Type': 'application/json',
          },
        });

        console.log(response);
        if (response.status === 200) {
          this.vagas = response.data.jobs;
          this.filteredVagas = [...this.vagas];
        } else {
          alert('Erro ao carregar as vagas em andamento.');
        }
      } catch (error) {
        console.error('Erro ao carregar as vagas em andamento:', error);
        alert('Ocorreu um erro ao tentar carregar as vagas. Tente novamente.');
      }
    },

    applyFilters() {
      this.filteredVagas = this.vagas.filter((vaga) => {
        const matchesSearchTerm = this.searchTerm
          ? vaga.title
            .toLowerCase()
            .includes(this.searchTerm.toLowerCase()) ||
          vaga.jobs_description
            .toLowerCase()
            .includes(this.searchTerm.toLowerCase())
          : true;

        const matchesWorkModel = this.selectedWorkModel
          ? vaga.work_model === this.selectedWorkModel
          : true;

        const matchesJobType = this.selectedJobType
          ? vaga.job_type === this.selectedJobType
          : true;

        return matchesSearchTerm && matchesWorkModel && matchesJobType;
      });
    },
    viewVaga(vaga) {
      if (!this.getAuthToken) {
        // Caso não tenha token, redireciona para o login
        this.$router.push({ name: 'login' });
      } else {
        // Se tiver token, prossegue para a página da vaga
        this.$router.push({ name: 'ver-vaga', params: { id: vaga.id } });
      }
    },

  },

}
</script>

<style></style>