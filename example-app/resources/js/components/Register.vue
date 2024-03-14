<template>
  <div class="registration-container">
    <h1>Register New Admin</h1>
    <form @submit.prevent="handleAdminRegistration">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="form.name" @input="clearError('name')">
        <div v-if="errors.name" class="error-message">{{ errors.name }}</div>
      </div>
      <div>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" v-model="form.last_name" @input="clearError('last_name')">
        <div v-if="errors.last_name" class="error-message">{{ errors.last_name }}</div>
        <div v-if="errors.emailFormat" class="error-message">{{ errors.emailFormat }}</div>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" @input="clearError('email')">
        <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="form.password" @input="clearError('password')">
        <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
      </div>
      <button type="submit">Register</button>
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
          password: ''
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

        if (!this.form.name) this.errors.name = 'Name required';
        if (!this.form.last_name) this.errors.last_name = 'Last name required';
        if (!this.form.email) this.errors.email = 'Email required';
        if (!this.form.password) this.errors.password = 'Password required';

        setTimeout(() => {
          this.errors.name = '';
          this.errors.last_name = '';
          this.errors.email = '';
          this.errors.password = '';
        }, 2000);

        if (!Object.values(this.errors).some(error => error)) {
          try {
            const response = await axios.post('/api/register-admin', this.form);
            if (response.status === 200 && response.data.message === 'Admin registered successfully') {
              store.commit('setAuthenticated', true);
              this.$router.push('/admin-home');
            }
          } catch (error) {
            console.error('Error registering admin:', error);
          }
        }
      }
    }
  };
</script>

<style lang="scss" scoped>
  .error-message {
    color: red;
    font-size: 0.8em;
    margin-bottom: 10px;
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
    margin-bottom: 10px;
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
