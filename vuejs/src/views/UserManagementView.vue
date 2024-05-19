<template>
    <div>
        <h1>User Management</h1>
        <button @click="addUser" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add
            User
        </button>
        <button @click="deleteSelectedUsers"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete Selected
        </button>
        <table>

            <tr>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">First Name</th>
                <th class="px-4 py-2">Last Name</th>
                <th class="px-4 py-2">Address</th>
                <th class="px-4 py-2">Postcode</th>
                <th class="px-4 py-2">Contact Phone Number</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td class="px-4 py-2"><input type="checkbox" v-model="selectedUsers" :value="user.id"></td>
                <td class="px-4 py-2">{{ user.firstname }}</td>
                <td class="px-4 py-2">{{ user.lastname }}</td>
                <td class="px-4 py-2">{{ user.address }}</td>
                <td class="px-4 py-2">{{ user.postcode }}</td>
                <td class="px-4 py-2">{{ user.contact_phone_number }}</td>
                <td class="px-4 py-2">{{ user.email }}</td>
                <td class="px-4 py-2">{{ user.username }}</td>
                <td class="px-4 py-2">
                    <button @click="editUser(user.id)"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                    <button @click="deleteUser(user.id)"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import { ref, onBeforeMount } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    name: 'user-management',
    setup() {
        const users = ref([]);
        const selectedUsers = ref([]);
        const router = useRouter();

        // Retrieve the token from localStorage
        const token = localStorage.getItem('sanctum_generated_token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }

        const addUser = () => {
            router.push('/users/add');
        };

        const editUser = (id) => {
            router.push(`/users/edit/${id}`);
        };

        const fetchUsers = async () => {
            const response = await axios.get('http://localhost:8001/api/users');
            users.value = response.data;
        };

        const deleteUser = async (id) => {
            await axios.delete(`http://localhost:8001/api/users/delete?ids=${id}`);
            fetchUsers();
        };

        const deleteSelectedUsers = () => {
            deleteUser(selectedUsers.value);
            selectedUsers.value = []; // Clear selected users after deletion
        };


        onBeforeMount(fetchUsers)

        return {
            users,
            addUser,
            editUser,
            deleteUser,
            fetchUsers,
            selectedUsers,
            deleteSelectedUsers
        };
    },
};
</script>
