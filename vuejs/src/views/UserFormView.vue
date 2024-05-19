<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-6">{{ userId ? 'Edit User' : 'Add User' }}</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="firstname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input v-model="form.firstname" id="firstname" type="text" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="lastname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input v-model="form.lastname" id="lastname" type="text" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input v-model="form.address" id="address" type="text" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="postcode" class="block text-sm font-medium text-gray-700">Postcode</label>
                <input v-model="form.postcode" id="postcode" type="text" placeholder="0000" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="contact_phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input v-model="form.contact_phone_number" id="contact_phone_number" type="text"
                    placeholder="+639123456789" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" id="email" type="email" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input v-model="form.username" id="username" type="text" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div v-if="!userId">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input v-model="form.password" id="password" type="password" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <button type="submit"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ userId ? 'Update' : 'Add' }}
            </button>
        </form>
    </div>
</template>


<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from '../axios';

export default {
    name: 'UserForm',
    setup() {
        const form = ref({
            firstname: '',
            lastname: '',
            address: '',
            postcode: '',
            contact_phone_number: '',
            email: '',
            username: '',
            password: '',
        });
        const route = useRoute();
        const router = useRouter();
        const userId = ref(route.params.id);

        // Retrieve the token from localStorage
        const token = localStorage.getItem('sanctum_generated_token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }

        const fetchUser = async (id) => {
            const response = await axios.get(`/users/${id}`);
            form.value = response.data;
        };

        const submitForm = async () => {
            if (userId.value) {
                try {
                    await axios.put(`/users/${userId.value}`, form.value);
                    router.push('/user-management');
                } catch (error) {
                    alert(error.response.data.message);
                }
            } else {
                try {
                    await axios.post('/users', form.value);
                    router.push('/user-management');
                } catch (error) {
                    alert(error.response.data.message);
                }
            }
        };

        onMounted(() => {
            if (userId.value) {
                fetchUser(userId.value);
            }
        });

        return {
            form,
            userId,
            submitForm,
        };
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>