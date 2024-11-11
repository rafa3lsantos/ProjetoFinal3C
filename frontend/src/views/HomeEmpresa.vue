<template>
    <div>
        <NavbarEmpresa />
        <SearchMain />
    </div>
</template>

<script>
    import NavbarEmpresa from '@/components/NavbarEmpresa.vue';
    import SearchMain from '@/components/SearchMain.vue';

export default {
    name: 'HomeEmpresa',
    components: {
        NavbarEmpresa,
        SearchMain,
    },
}
</script>

<style>

</style>