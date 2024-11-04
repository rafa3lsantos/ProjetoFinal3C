<template>
    <div class="container d-flex justify-content-center align-items-start" style="min-height: calc(100vh - 100px);">
        <div class="input-group">
            <div class="form-outline">
                <div class="input-with-icon">
                    <img :src="searchIcon" alt="search" width="20px" class="input-icon" />
                    <input v-model="searchQuery" type="search" class="form-control"
                        placeholder="Cargo, palavra-chave ou empresa" />
                </div>
            </div>

            <div class="form-outline ms-2">
                <div class="input-with-icon">
                    <img :src="locationIcon" alt="location" width="20px" class="input-icon" />
                    <input v-model="filterQuery" type="text" class="form-control"
                        placeholder="Cidade, estado, região ou 'remoto'." />
                </div>
            </div>

            <div class="button-search">
                <button type="button" class="btn btn-primary ms-2" @click="handleSearch">
                    Buscar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchMain",
    data() {
        return {
            searchQuery: "",
            filterQuery: "",
            searchIcon: "../../public/search.png",
            locationIcon: "../../public/black-placeholder-variant.png",
        };
    },
    methods: {
        handleSearch() {
            alert(`Search: ${this.searchQuery}, Filter: ${this.filterQuery}`);
        },
    },
};
</script>

<style scoped>
.input-group {
    display: flex;
    width: 100%;
    max-width: 800px;
    margin-top: 100px;
}

.form-outline {
    flex: 1;
}

.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

.form-control {
    padding-left: 40px;
}

.button-search {
    margin-top: 0px;
}
</style>
