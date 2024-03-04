<template>
    <div class="home-container">
      <h2>Welcome to Our Website!</h2>
      <p>
        Welcome, {{ $route.query.adminName }}!
      </p>
      <button @click="logout">Logout</button>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
    methods: {
      logout() {
        // Redirect the user to the Login page
        this.$router.push({ name: 'Login' });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Your styles here */
  </style>  