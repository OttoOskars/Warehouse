<template>
  <div class="registration-container">
    <h1>Register New Admin</h1>
    <form @submit.prevent="handleAdminRegistration">
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="person-outline"></ion-icon>
          <label for="name">Name:</label>
        </div>
        <input type="text" id="name" v-model="form.name" @input="clearError('name')">
        <div v-if="errors.name" class="error-message">{{ errors.name }}</div>
      </div>
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="person-outline"></ion-icon>
          <label for="last_name">Last Name:</label>
        </div>
        <input type="text" id="last_name" v-model="form.last_name" @input="clearError('last_name')">
        <div v-if="errors.last_name" class="error-message">{{ errors.last_name }}</div>
      </div>
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="mail-outline"></ion-icon>
          <label for="email">Email:</label>
        </div>
        <input type="text" id="email" v-model="form.email" @input="clearError('email')">
        <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
        <div v-if="errors.emailFormat && form.email" class="error-message">{{ errors.emailFormat }}</div>
        <div v-if="errors.emailTaken" class="error-message">{{ errors.emailTaken }}</div>
      </div>
      <div class="input-group">
        <div class="label-wrapper">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <label for="password">Password:</label>
        </div>
        <input type="password" id="password" v-model="form.password" @input="clearError('password')">
        <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
        <div v-if="errors.passwordLength" class="error-message">{{ errors.passwordLength }}</div>
      </div>
      <button type="submit"><ion-icon class="arrow" name="arrow-forward-outline"></ion-icon>Register</button>
    </form>
    <router-link to="/login" class="link">Already have an account? Login</router-link>
  </div>
</template>

<script>
import axios from 'axios';
import store from '../store';

export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        last_name: '',
        email: '',
        password: ''
      },
      errors: {
        name: '',
        last_name: '',
        email: '',
        emailFormat: '',
        emailTaken: '',
        password: '',
        passwordLength: ''
      }
    };
  },
  methods: {
    clearError(field) {
      this.errors[field] = '';
    },
    async handleAdminRegistration() {
      this.errors.name = '';
      this.errors.last_name = '';
      this.errors.email = '';
      this.errors.password = '';
      this.errors.emailTaken = '';
      this.errors.passwordLength = '';

      if (!this.form.name.trim()) this.errors.name = 'Name required';
      else if (/\s/.test(this.form.name)) this.errors.name = 'Name should not contain spaces';
      
      if (!this.form.last_name.trim()) this.errors.last_name = 'Last name required';
      else if (/\s/.test(this.form.last_name)) this.errors.last_name = 'Last name should not contain spaces';
      
      if (!this.form.email.trim()) this.errors.email = 'Email required';
      if (!this.form.password.trim()) this.errors.password = 'Password required';
      else if (this.form.password.trim().length < 8) this.errors.passwordLength = 'Password must be at least 8 characters long';
      
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.form.email.trim()) && this.form.email.trim()) this.errors.emailFormat = 'Invalid email format';
      else this.errors.emailFormat = '';

      setTimeout(() => {
        this.errors.name = '';
        this.errors.last_name = '';
        this.errors.email = '';
        this.errors.password = '';
        this.errors.emailFormat = '';
        this.errors.emailTaken = '';
        this.errors.passwordLength = '';
      }, 2000);

      if (!Object.values(this.errors).some(error => error)) {
        try {
          const response = await axios.post('/api/register-admin', this.form);
          if (response.status === 200 && response.data.message === 'Admin registered successfully') {
            store.commit('setAuthenticated', true);
            this.$router.push('/admin-home');
          }
        } catch (error) {
          if (error.response && error.response.status === 422 && error.response.data.error.email) {
            this.errors.emailTaken = 'Email is already taken';
          } else {
            console.error('Error registering admin:', error);
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
  .registration-container {
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
    .registration-container {
      width: 90%;
    }
  }
</style>
