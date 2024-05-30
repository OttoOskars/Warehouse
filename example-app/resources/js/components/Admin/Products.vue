<template>
    <div>
       <h1>Products</h1>
       <form @submit.prevent="addProduct">
        <div>
            <label for="name">Product Name:</label>
            <input type="text" v-model="product.name" required />
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" v-model="product.description" required />
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" v-model="product.price" required />
        </div>
        <div>
            <label for="manufacturer_id">Manufacturer ID:</label>
            <input type="number" v-model="product.manufacturer_id" required />
        </div>
        <button type="submit">Add Product</button>
        </form>
        <div v-if="error" class="error-message">{{ error }}</div>
    </div>
</template>
   
<script>
    import axios from 'axios';
    export default {
        name: 'Products',
        data() {
            return {
            product: {
                name: '',
                description: '',
                price: 0,
                manufacturer_id: ''
            },
            error: null
            };
        },
        methods: {
            async addProduct() {
                this.error = null;
                try {
                    const response = await axios.post('/api/products', this.product);
                    console.log('Product added:', response.data);
                    this.product = { name: '', description: '', price: 0, manufacturer_id: '' };
                } catch (error) {
                    if (error.response) {
                        this.error = error.response.data.message || 'Failed to add product';
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
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 2px;
        text-align: left;
    }
</style>   