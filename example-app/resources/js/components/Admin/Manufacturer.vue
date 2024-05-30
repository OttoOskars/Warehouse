<template>
    <div>
       <h1>Manufacturer</h1>
       <form @submit.prevent="addManufacturer">
        <div>
            <label for="name">Name:</label>
            <input type="text" v-model="manufacturer.name" required />
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" v-model="manufacturer.description" required />
        </div>
        <div>
            <label for="location">Location:</label>
            <input type="text" v-model="manufacturer.location" required />
        </div>
        <div>
            <label for="contact">Contact:</label>
            <input type="text" v-model="manufacturer.contact" required />
        </div>
        <button type="submit">Add Manufacturer</button>
        </form>
        <div v-if="error" class="error">{{ error }}</div>
    </div>
</template>
   
<script>
    import axios from 'axios';
    export default {
        name: 'Manufacturer',
        data() {
            return {
            manufacturer: {
                name: '',
                description: '',
                location: '',
                contact: ''
            },
            error: null
            };
        },
        methods: {
            async addManufacturer() {
                this.error = null;
                try {
                    const response = await axios.post('/api/manufacturers', this.manufacturer);
                    console.log('Manufacturer added:', response.data);
                    this.manufacturer = { name: '', description: '', location: '', contact: '' };
                } catch (error) {
                    if (error.response) {
                        this.error = error.response.data.message || 'Failed to add manufacturer';
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
</style>   