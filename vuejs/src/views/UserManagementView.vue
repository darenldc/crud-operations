<template>
    <div>
        <h1>User Management</h1>
        <button @click="addUser">Add User</button>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Postcode</th>
                <th>Contact Phone Number</th>
                <th>Email</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.firstname }}</td>
                <td>{{ user.lastname }}</td>
                <td>{{ user.address }}</td>
                <td>{{ user.postcode }}</td>
                <td>{{ user.contact_phone_number }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.username }}</td>

                <td>
                    <button @click="editUser(user.id)">Edit</button>
                    <button @click="deleteUser(user.id)">Delete</button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    name: 'user-management',
    data() {
        return {
            users: [],
        }
    },
    methods: {
        async fetchUsers() {
            const response = await axios.get('http://localhost:8001/api/users', { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            this.users = response.data;
        },
        async deleteUser(id) {
            await axios.delete(`http://localhost:8001/api/users/delete?ids=${id}`, { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } });
            this.fetchUsers();
        }
    },
    beforeMount() {
        this.fetchUsers();
    },
    setup() {
        const users = ref([]);
        const router = useRouter();

        const addUser = () => {
            router.push('/users/add');
        };

        const editUser = (id) => {
            router.push(`/users/edit/${id}`);
        };

        return {
            users,
            addUser,
            editUser,
        };
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>