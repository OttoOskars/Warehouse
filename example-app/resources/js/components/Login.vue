<template>
  <div class="login-container">
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="mail-outline"></ion-icon>
          <label for="email">Email:</label>
        </div>
        <input type="text" id="email" v-model="form.email" @input="clearError('email')">
        <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
        <div v-if="errors.emailFormat" class="error-message">{{ errors.emailFormat }}</div>
        <div v-if="errors.emailNotRegistered" class="error-message">{{ errors.emailNotRegistered }}</div>
      </div>
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <label for="password">Password:</label>
        </div>
        <input type="password" id="password" v-model="form.password" @input="clearError('password')">
        <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
        <div v-if="errors.invalidPassword" class="error-message">{{ errors.invalidPassword }}</div>
      </div>
      <button type="submit"><ion-icon class="arrow" name="log-in-outline"></ion-icon>Login</button>
    </form>
    <router-link to="/register" class="link">Don't have an account? Register</router-link>
  </div>
</template>

<script>
  import axios from 'axios';
  import store from '../store';

  export default {
    name: 'Login',
    data() {
      return {
        form: {
          email: '',
          password: ''
        },
        errors: {
          email: '',
          emailFormat: '',
          emailNotRegistered: '',
          password: '',
          invalidPassword: ''
        }
      };
    },
    methods: {
      clearError(field) {
        this.errors[field] = '';
      },
      async login() {
        this.errors.email = '';
        this.errors.password = '';
        this.errors.emailNotRegistered = '';
        this.errors.invalidPassword = '';

        if (!this.form.email.trim()) this.errors.email = 'Email required';
        if (!this.form.password.trim()) this.errors.password = 'Password required';

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.form.email.trim()) && this.form.email.trim()) this.errors.emailFormat = 'Invalid email format';
        else this.errors.emailFormat = '';

        setTimeout(() => {
          this.errors.email = '';
          this.errors.password = '';
          this.errors.emailFormat = '';
          this.errors.emailNotRegistered = '';
          this.errors.invalidPassword = '';
        }, 2000);

        if (!Object.values(this.errors).some(error => error)) {
    try {
      const response = await axios.post('/api/login', {
        email: this.form.email,
        password: this.form.password,
      });

      if (response.data && response.data.message === 'Login successful') {
        store.commit('setAuthenticated', true);

        if (response.data.role === 2) {
          this.$router.push({ name: 'WorkerHome' });
        } else if (response.data.role === 3) {
          this.$router.push({ name: 'OrganizerHome' });
        } else if (response.data.role === 1) {
          this.$router.push({ name: 'AdminHome' });
        }
      } else {
        alert('Login failed. Please try again.');
      }
    } catch (error) {
      if (error.response) {
        const data = error.response.data;
        if (data.error === 'Invalid email') {
          this.errors.emailNotRegistered = 'Email is not registered';
        } else if (data.error === 'Invalid password') {
          this.errors.invalidPassword = 'Invalid password';
        }
      } else {
        console.error('Login error:', error);
        alert('Login failed. Please try again.');
      }
    }
  }
      }
    }
  };
</script>
  
<style lang="scss" scoped>
  .error-message {
    color: red;
    font-size: 12px;
    margin-top: 2px;
  }
  .login-container {
    max-width: 400px;
    margin: 100px auto;
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
  .input-group {
    margin-bottom: 15px;
  }
  .label-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
  }
  .label-wrapper ion-icon {
    margin-right: 5px;
  }
  .arrow{
    padding-right: 5px;
  }
  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  input[type="text"],
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
    border-radius: 6px;
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
    .login-container {
      width: 90%;
    }
  }
</style>
