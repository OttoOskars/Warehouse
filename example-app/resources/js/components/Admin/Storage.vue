<template>
    <div class="storage-container">
       <h1>Storage</h1>
       <form @submit.prevent="addStorage">
        <div class="input-group">
            <div class="label-wrapper">
                <ion-icon name="home-outline"></ion-icon>
                <label for="name">Storage Name:</label>
            </div>
            <input type="text" v-model="storage.name" required />
        </div>
        <div class="input-group">
            <div class="label-wrapper">
                <ion-icon name="location-outline"></ion-icon>
                <label for="name">Location:</label>
            </div>
            <input type="text" v-model="storage.location" required />
        </div>
        <div class="input-group">
            <div class="label-wrapper">
                <ion-icon name="document-text-outline"></ion-icon>
                <label for="name">Description:</label>
            </div>
            <input type="text" v-model="storage.description" required />
        </div>
        <button type="submit"><ion-icon name="add-outline"></ion-icon>Add Storage</button>
        </form>
        <div v-if="error" class="error">{{ error }}</div>
    </div>
</template>
   
<script>
    import axios from 'axios';
    export default {
        name: 'Storage',
        data() {
            return {
            storage: {
                name: '',
                location: '',
                description: ''
            },
            error: null
            };
        },
        methods: {
            async addStorage() {
                this.error = null;
                try {
                    const response = await axios.post('/api/storage', this.storage);
                    console.log('Storage added:', response.data);
                    this.storage = { name: '', location: '', description: '' };
                } catch (error) {
                    if (error.response) {
                        this.error = error.response.data.message || 'Failed to add storage';
                    } else if (error.request) {
                        this.error = 'No response from server';
                    } else {
                        this.error = error.message;
                    }
                }
            }
        }
    };
</script>
   
<style lang="scss" scoped>
    .storage-container {
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
</style>   