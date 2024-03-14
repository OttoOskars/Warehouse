<template>
  <div class="home-container">
    <h1>Admin home</h1>
    <button @click="logout">Logout</button>
    <div v-if="showForm" class="form-container">
      <h3>Create New User</h3>
      <form @submit.prevent="createUser" class="user-form">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="newUser.name" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" v-model="newUser.last_name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="newUser.email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="newUser.password" required>
        <label for="role">Role:</label>
        <select id="role" v-model="newUser.role" required>
          <option value="2">Worker</option>
          <option value="3">Organizer</option>
        </select>
        <button type="submit">Create</button>
      </form>
    </div>

    <div v-if="users.length" class="users-list">
    <h2>Users</h2>
      <div class="card" v-for="user in users" :key="user.id">
        <div class="card-header">
          <h3>{{ user.name }} {{ user.last_name }}</h3>
        </div>
        <div class="card-body">
          <p>{{ user.email }}</p>
          <p>Role: {{ user.role_name }}</p>
        </div>
        <div class="card-footer">
          <button @click="editUser(user)">Edit</button>
          <button @click="deleteUser(user.id)">Delete</button>
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
        showForm: true,
        newUser: {
          name: '',
          last_name: '',
          email: '',
          password: '',
          role: ''
        },
        users: [],
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
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
        try {
          const response = await axios.post('/api/admin/create-user', this.newUser);
          console.log(response.data);
          this.fetchUsers();
        } catch (error) {
          console.error(error);
        }
      },
      async editUser(user) {
      },
      async deleteUser(userId) {
        console.log('User object:', user);
        console.log('Deleting user with ID:', userId);
        try {
          await axios.delete(`/api/admin/users/${userId}`);
          this.fetchUsers();
        } catch (error) {
          console.error('Error deleting user:', error);
        }
      },
    }
  };
</script>
  
<style lang="scss" scoped>
  .home-container {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: space-between;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
  }
  h1 {
    color: #333;
    margin-bottom: 20px;
  }
  button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-bottom: 20px;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
  .form-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
  }
  .user-form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .user-form label {
    margin-bottom: 5px;
  }
  .user-form input,
  .user-form select {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  .user-form button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }
  .user-form button:hover {
    background-color: #218838;
  }

  .users-list {
    margin-top: 20px;
  }
  .users-list ul {
    list-style: none;
    padding: 0;
  }
  .users-list li {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .users-list button {
    margin-left: 10px;
  }

  .card {
    background-color: #f0f0f0;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
    max-width: 400px;
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
      p {
        margin: 0 0 10px 0;
      }
    }
    .card-footer {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-top: 20px;
      button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        &:hover {
          background-color: #0056b3;
        }
      }
    }
  }

  @media (max-width: 768px) {
    .home-container {
      padding: 10px;
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