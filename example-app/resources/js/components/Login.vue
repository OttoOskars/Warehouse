<template>
    <div class="login-container">
      <h1>Login</h1>
      <form @submit.prevent="login" class="login-form">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Login</button>
      </form>
      <router-link to="/register" class="link">Don't have an account? Register</router-link>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        });

        // Assuming login was successful based on the response
        if (response.data && response.data.message === 'Admin login successful') {
          // Redirect to the homepage with the admin's name
          this.$router.push({ name: 'Home', query: { adminName: response.data.name } });
        } else {
          // Handle unsuccessful login
          alert('Login failed. Please try again.');
        }
      } catch (error) {
        // Handle login error
        console.error('Login error:', error);
        alert('Login failed. Please try again.');
      }
    }
  }
};
</script>
  
<style lang="scss" scoped>
  .login-container {
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
  
  .login-form {
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  input[type="email"],
  input[type="password"],
  button {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
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
    margin-top: 30px; /* Move the router-link down */
  }
  
  .link:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .login-container {
      width: 90%;
    }
  }
</style>
