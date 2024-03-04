<template>
    <div class="registration-container">
        <h1>Register New Admin</h1>
        <form @submit.prevent="handleAdminRegistration">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name">
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" v-model="form.last_name">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="form.email">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="form.password">
            </div>
            <button type="submit">Register</button>
        </form>
        <router-link to="/login" class="link">Already have an account? Login</router-link>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        last_name: '',
        email: '',
        password: ''
      }
    };
  },
  methods: {
    async handleAdminRegistration() {
      try {
        const response = await axios.post('/api/register-admin', this.form);
        if (response.status === 200 && response.data.message === 'Admin registered successfully') {
          // Redirect to Home.vue with admin name as query parameter
          this.$router.push({ name: 'Home', query: { adminName: this.form.name } });
        }
      } catch (error) {
        console.error('Error registering admin:', error);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
  /* Reuse the styles from the login template */
  .registration-container {
    max-width: 400px;
    margin: 100px auto; /* Center the container vertically and horizontally */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  form {
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
  }
  
  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  input[type="text"],
  input[type="email"],
  input[type="password"],
  button {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 10px; /* Add some spacing between form fields */
  }
  
  button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  
  .link {
    display: block;
    text-align: center;
    color: #007bff;
    text-decoration: none;
    margin-top: 20px;
  }
  
  .link:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .registration-container {
      width: 90%;
    }
  }
</style>
