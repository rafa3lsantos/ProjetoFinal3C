<template>
    <div>
        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle"></div>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">3Cvagas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <router-link to="/home-empresa" class="nav-link active"
                                aria-current="page">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/add-recrutador" class="nav-link">Adicionar Recrutador</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/recrutadores" class="nav-link">Recrutadores</router-link>
                        </li>
                    </ul>
                </div>

                <div class="user ms-auto">
                    <div class="dropdown" @click="toggleDropdown">
                        <img :src="arrowUser" alt="Ícone de seta" class="rounded-circle user-icon arrow" width="15" />
                        <img :src="userImage" alt="Foto do Usuário" class="rounded-circle user-icon" width="40"
                            height="40" />
                        <div v-if="isDropdownOpen" class="dropdown-menu custom-dropdown show text-center">
                            <router-link to="/perfil-empresa" class="dropdown-item">Perfil Empresa</router-link>
                            <router-link to="/add-recrutador" class="dropdown-item">Adicionar Recrutador</router-link>
                            <router-link to="/recrutadores" class="dropdown-item">Recrutadores</router-link>
                            <a @click.prevent="handleLogout" class="dropdown-item exit-color">
                                Sair <img width="15px" src="../../public/logout.png" alt="Sair">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
import HttpService from '@/services/HttpService';
import { mapGetters } from 'vuex';

export default {
    name: 'Navbar',
    data() {
        return {
            isDropdownOpen: false,
            arrowUser: '../../public/down.png',
            userImage: '../../public/user.png',
        };
    },
    computed: {
        ...mapGetters(['getCompanyId']),
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        async fetchUserImage() {
            try {
                const token = localStorage.getItem('authToken') || '';
                const response = await HttpService.get(`/company/show/${this.getCompanyId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                const company = response.data.company;
                if (company.company_photo) {
                    this.userImage = `http://127.0.0.1:8000/storage/${company.company_photo}`;
                }
            } catch (error) {
                console.error('Erro ao carregar a imagem do usuário:', error);
            }
        },
        async handleLogout() {
            await this.$store.dispatch('logout');
            this.$router.push({ name: 'login' });
        },
    },
    created() {
        this.fetchUserImage();
    },
};
</script>

<style scoped>
.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}

.pesquisa {
    display: flex;
    margin-right: 300px;
}

.user {
    margin-right: 50px;
}

.arrow {
    margin-right: 10px;
}

.custom-dropdown {
    background-color: #f8f9fa;
    margin-top: 5px;
    left: auto;
    right: 0;
    width: 100%;
}

.dropdown-menu {
    text-align: center;
    width: 200px;
}

.dropdown-item {
    display: inline-block;
    width: 100%;
}

.exit-color {
    color: #c01c1c;
}

.icon-location {
    right: 50px;
}
</style>
