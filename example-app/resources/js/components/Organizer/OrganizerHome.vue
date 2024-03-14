<template>
    <div>
       <h1>Organizer Home</h1>
       <p>Welcome, organizer! This is your personalized home page.</p>
       <button @click="logout">Logout</button>
    </div>
</template>
   
<script>
    export default {
        name: 'OrganizerHome',
        methods: {
            async logout() {
                await this.$store.dispatch('logout');
                this.$router.push('/login');
            },
        }
    };
</script>
   
<style lang="scss" scoped>
</style>   