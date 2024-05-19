<template>
    <div>
        <h1>{{ userId ? 'Edit User' : 'Add User' }}</h1>
        <form @submit.prevent="submitForm" class="flex flex-col ">
            <div>
                <label for="firstname">First Name</label>
                <input v-model="form.firstname" id="firstname" placeholder="First Name" required>
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input v-model="form.lastname" id="lastname" placeholder="Last Name" required>
            </div>
            <div>
                <label for="address">Address</label>
                <input v-model="form.address" id="address" placeholder="Address" required>
            </div>
            <div>
                <label for="postcode">Postcode</label>
                <input v-model="form.postcode" id="postcode" placeholder="Postcode" required>
            </div>
            <div>
                <label for="contact_phone_number">Phone Number</label>
                <input v-model="form.contact_phone_number" id="contact_phone_number" placeholder="Phone Number"
                    required>
            </div>
            <div>
                <label for="email">Email</label>
                <input v-model="form.email" id="email" type="email" placeholder="Email" required>
            </div>
            <div>
                <label for="username">Username</label>
                <input v-model="form.username" id="username" placeholder="Username" required>
            </div>
            <div v-if="!userId">
                <label for="password">Password</label>
                <input v-model="form.password" id="password" type="password" placeholder="Password" required>
            </div>
            <button type="submit">{{ userId ? 'Update' : 'Add' }}</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

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

        const fetchUser = async (id) => {
            const response = await axios.get(`http://localhost:8001/api/users/${id}`, { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            form.value = response.data;
        };

        const submitForm = async () => {
            if (userId.value) {
                await axios.put(`http://localhost:8001/api/users/${userId.value}`, form.value, { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            } else {
                await axios.post('http://localhost:8001/api/users', form.value, { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            }
            router.push('/user-management');
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