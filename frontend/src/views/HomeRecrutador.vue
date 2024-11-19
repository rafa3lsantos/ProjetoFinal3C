<template>
    <div>
        <NavbarRecrutador />
        <SearchMain />
    </div>
</template>

<script>
    import NavbarRecrutador from '@/components/NavbarRecrutador.vue';
    import SearchMain from '@/components/SearchMain.vue';

export default {
    name: 'HomeEmpresa',
    components: {
        NavbarRecrutador,
        SearchMain,
    },
}
</script>

<style>

</style>