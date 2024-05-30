<template>
    <div>
       <h1>Orders</h1>
       <form @submit.prevent="placeOrder">
        <div>
            <label for="product_id">Product ID:</label>
            <input type="number" v-model="order.product_id" required />
        </div>
        <div>
            <label for="storage_id">Storage ID:</label>
            <input type="number" v-model="order.storage_id" required />
        </div>
        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" v-model="order.quantity" required />
        </div>
        <button type="submit" :disabled="!$store.state.isAuthenticated">Place Order</button>
        </form>
        <div v-if="error" class="error-message">{{ error }}</div>
    </div>
</template>
   
<script>
    import axios from 'axios';
    export default {
        name: 'Orders',
        data() {
            return {
            order: {
                product_id: null,
                storage_id: null,
                quantity: null
            },
            error: null
            };
        },
        methods: {
            async placeOrder() {
                this.error = null;
                try {
                    if (!this.$store.state.isAuthenticated) {
                        throw new Error('User is not authenticated'); // Handle unauthorized user
                    }

                    const productResponse = await axios.get(`/api/products/${this.order.product_id}`);
                    if (!productResponse.data) {
                    throw new Error('Selected product does not exist');
                    }

                    const storageResponse = await axios.get(`/api/storage/${this.order.storage_id}`);
                    if (!storageResponse.data) {
                    throw new Error('Selected storage does not exist');
                    }

                    const response = await axios.post('/api/orders', {
                    ...this.order,
                    status_id: 1 
                    });
                    console.log('Order placed:', response.data);
                    this.order = { product_id: null, storage_id: null, quantity: null };
                } catch (error) {
                    this.error = error.message;
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