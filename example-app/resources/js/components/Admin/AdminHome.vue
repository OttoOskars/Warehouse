<template>
  <div class="home-container">
    <div class="top">
      <h1 class="home">Admin home</h1>
      <div class="nav-buttons">
        <button class="nav-button" @click="goToStorage">Storage</button>
        <button class="nav-button" @click="goToProducts">Products</button>
        <button class="nav-button" @click="goToOrders">Orders</button>
        <button class="nav-button" @click="goToReports">Reports</button>
        <button class="nav-button" @click="goToManufacturer">Manufacturer</button>
        <button class="logout" @click="logout"><ion-icon class="arrow" name="log-out-outline"></ion-icon>Logout</button>
      </div>
    </div>
  
    <div class="main">
      <div class="new-form">
        <h3 class="new-user">Create New User</h3>
        <form @submit.prevent="createUser">

          <div class="input-group">
            <div class="label-wrapper">
              <ion-icon name="person-outline"></ion-icon>
              <label for="name">Name:</label>
            </div>
            <input type="text" id="name" v-model="newUser.name" @input="clearError('name')">
            <div v-if="errors.name" class="error-message">{{ errors.name }}</div>
          </div>

          <div class="input-group">
            <div class="label-wrapper">
              <ion-icon name="person-outline"></ion-icon>
              <label for="last_name">Last Name:</label>
            </div>
            <input type="text" id="last_name" v-model="newUser.last_name" @input="clearError('last_name')">
            <div v-if="errors.last_name" class="error-message">{{ errors.last_name }}</div>
          </div>

          <div class="input-group">
            <div class="label-wrapper">
              <ion-icon name="mail-outline"></ion-icon>
              <label for="email">Email:</label>
            </div>
            <input type="text" id="email" v-model="newUser.email" @input="clearError('email')">
            <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
            <div v-if="errors.emailFormat && newUser.email" class="error-message">{{ errors.emailFormat }}</div>
            <div v-if="errors.emailTaken" class="error-message">{{ errors.emailTaken }}</div>
          </div>

          <div class="input-group">
            <div class="label-wrapper">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <label for="password">Password:</label>
            </div>
            <input type="password" id="password" v-model="newUser.password" @input="clearError('password')">
            <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
            <div v-if="errors.passwordLength" class="error-message">{{ errors.passwordLength }}</div>
          </div>

          <div class="label-wrapper">
            <ion-icon name="people-outline"></ion-icon>
            <label for="role">Role:</label>
            <select id="role" v-model="newUser.role">
              <option value="2">Worker</option>
              <option value="3">Organizer</option>
            </select>
          </div>
          <div v-if="errors.role" class="error-message">{{ errors.role }}</div>
          <button class="create" type="submit"><ion-icon class="arrow" name="create-outline"></ion-icon>Create</button>
        </form>
      </div>
      <div v-if="users.length" class="users-list">
        <h3>Users</h3>
        <div class="card" v-for="user in users" :key="user.user_id">
          <div class="card-header">
            <h3>{{ user.name }} {{ user.last_name }}</h3>
          </div>
          <div class="card-body">
            <div class="worker-email">
              <ion-icon name="mail-outline"></ion-icon>
              <p>{{ user.email }}</p>
            </div>
            <div class="worker-role">
              <ion-icon name="people-outline"></ion-icon>
              <p>{{ user.role_name }}</p>
            </div>
          </div>
          <div class="card-footer">
            <button class="edit" @click="editUser(user)"><ion-icon class="arrow" name="create-outline"></ion-icon>Edit</button>
            <button class="delete" @click="deleteUser(user.user_id)"><ion-icon class="arrow" name="trash-outline"></ion-icon>Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
  import axios from 'axios';
  export default {
    name: 'AdminHome',
    data() {
      return {
        newUser: {
          name: '',
          last_name: '',
          email: '',
          password: '',
          role: ''
        },
        errors: {
          name: '',
          last_name: '',
          email: '',
          emailFormat: '',
          emailTaken: '',
          password: '',
          passwordLength: '',
          role: ''
        },
        users: [],
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      goToStorage() {
        this.$router.push({ name: 'Storage' });
      },
      goToProducts() {
        this.$router.push({ name: 'Products' });
      },
      goToOrders() {
        this.$router.push({ name: 'Orders' });
      },
      goToReports() {
        this.$router.push({ name: 'Reports' });
      },
      goToManufacturer() {
        this.$router.push({ name: 'Manufacturer' });
      },
      clearError(field) {
        this.errors[field] = '';
      },
      async fetchUsers() {
        try {
          const response = await axios.get('/api/admin/users');
          this.users = response.data;
        } catch (error) {
          console.error('Error fetching users:', error);
        }
      },
      async logout() {
        await this.$store.dispatch('logout');
        this.$router.push('/login');
      },
      async createUser() {
        this.errors.name = '';
        this.errors.last_name = '';
        this.errors.email = '';
        this.errors.password = '';
        this.errors.emailTaken = '';
        this.errors.passwordLength = '';
        this.errors.role = '';

        if (!this.newUser.name.trim()) this.errors.name = 'Name required';
        else if (/\s/.test(this.newUser.name)) this.errors.name = 'Name should not contain spaces';
        
        if (!this.newUser.last_name.trim()) this.errors.last_name = 'Last name required';
        else if (/\s/.test(this.newUser.last_name)) this.errors.last_name = 'Last name should not contain spaces';
        
        if (!this.newUser.email.trim()) this.errors.email = 'Email required';
        if (!this.newUser.password.trim()) this.errors.password = 'Password required';
        else if (this.newUser.password.trim().length < 8) this.errors.passwordLength = 'Password must be at least 8 characters long';
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.newUser.email.trim()) && this.newUser.email.trim()) this.errors.emailFormat = 'Invalid email format';
        else this.errors.emailFormat = '';

        if (!this.newUser.role.trim()) this.errors.role = 'Role required';

        setTimeout(() => {
          this.errors.name = '';
          this.errors.last_name = '';
          this.errors.email = '';
          this.errors.password = '';
          this.errors.emailFormat = '';
          this.errors.emailTaken = '';
          this.errors.passwordLength = '';
          this.errors.role = '';
        }, 2000);

        if (!Object.values(this.errors).some(error => error)) {
          try {
            const response = await axios.post('/api/admin/create-user', this.newUser);
            if (response.status === 200 && response.data.message === 'User created successfully') {
              this.fetchUsers();
              this.newUser.name = '';
              this.newUser.last_name = '';
              this.newUser.email = '';
              this.newUser.password = '';
              this.newUser.role = '';
            }
          } catch (error) {
            if (error.response && error.response.status === 422 && error.response.data.error.email) {
              this.errors.emailTaken = 'Email is already taken';
            } else {
              console.error('Error creating user:', error);
            }
          }
        }
      },
      async editUser(user) {
      },
      async deleteUser(userId) {
        console.log('Deleting user with ID:', userId);
        try {
          await axios.delete(`/api/admin/users/${userId}`);
          this.fetchUsers();
        } catch (error) {
          console.error('Error deleting user:', error.response ? error.response.data : error.message);
        }
      },
    }
  };
</script>
  
<style lang="scss" scoped>
  .arrow{
    padding-right: 5px;
  }
  .error-message {
    color: red;
    font-size: 12px;
    margin-top: 2px;
    text-align: left;
  }
  .home-container {
    display: flex;
    flex-direction: column;
    //align-items: flex-start;
    //justify-content: space-between;
    //max-width: 800px;
    margin: 0 auto;
    padding: 10px;
    text-align: center;
    .top{
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      width: 100%;
      border-bottom: 1px solid black;
      // .home{
      //   justify-content: flex-start;
      // }
      .nav-buttons{
        display: flex;
        flex-direction: row;
        gap: 5px;
        .nav-button{
          background-color: white;
          color: black;
          border: none;
          text-decoration: underline;
          //border-radius: 6px;
          padding: 10px 20px;
          margin-bottom: 20px;
          width: 150px;
          height: 50px;
          font-size: 16px;
          //margin-right: 100px;
          cursor: pointer;
          // &:hover{
          //   background-color: ;
          // }
        }
        // justify-content: space-between;
        .logout{
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 6px;
          padding: 10px 20px;
          margin-bottom: 20px;
          width: 150px;
          height: 50px;
          font-size: 16px;
          //margin-right: 100px;
          cursor: pointer;
          &:hover{
            background-color: #0056b3;
          }
        }
      }
    }
    .main{
      display: flex;
      flex-direction: row;
      width: 100%;
      .new-form{
        display: flex;
        flex-direction: column;
        width: 50%;
        border-right: 1px solid black;
        form {
          width: 100%;
          max-width: 600px;
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
          border-radius: 6px;
          font-size: 16px;
        }
        .create {
          background-color: green;
          color: white;
          border: none;
          padding: 10px 20px;
          border-radius: 5px;
          cursor: pointer;
          &:hover {
            background-color: #218838;
          }
        }
      }
      .users-list{
        display: flex;
        flex-direction: column;
        width: 50%;
        max-height: 500px;
        overflow-y: auto;
        &::-webkit-scrollbar{
          width:4px;
        }
        &::-webkit-scrollbar-thumb{
          background-color: #2F3336;
          border-radius: 5px;
          border:none;
        }
        &::-webkit-scrollbar-track{
          background:none;
          border:none;
        }
        &:disabled{
          color:#808080;
        }
        .card {
          background-color: #f0f0f0;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          margin-bottom: 20px;
          padding: 20px;
          width: 600px;
          margin: 0 auto;
          margin-bottom: 20px;
          .card-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
            h3 {
              margin: 0;
            }
          }
          .card-body {
            justify-content: center;
            .worker-email, .worker-role{
              display: flex;
              flex-direction: row;
            }
            p {
              margin: 0 0 10px 5px;
            }
          }
          .card-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 20px;
            .edit {
              background-color: green;
              color: white;
              border: none;
              padding: 10px 20px;
              border-radius: 5px;
              cursor: pointer;
              margin-left: 10px;
              font-size: 16px;
              &:hover {
                background-color: #218838;
              }
            }
            .delete {
              background-color: red;
              color: white;
              border: none;
              padding: 10px 20px;
              border-radius: 5px;
              cursor: pointer;
              margin-left: 10px;
              font-size: 16px;
              &:hover {
                background-color: #f11818;
              }
            }
          }
        }
      }
    }
  }

  @media (max-width: 768px) {
    .home-container {
      padding: 10px;
      .main{
        display: flex;
        flex-direction: column;
      }
    }
    .user-form {
      width: 100%;
    }
    .user-form input,
    .user-form select,
    .user-form button {
      width: 100%;
      box-sizing: border-box;
    }
  }
</style>