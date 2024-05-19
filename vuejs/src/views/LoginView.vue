<template>
    <div class="card flex justify-center">
        <form @submit.prevent="login" class="flex flex-col gap-2">
            <h1>Login</h1>
            <label for="username">Username</label>
            <InputText class="text-black" id="username" v-model="form.username" aria-describedby="username-help"
                required />
            <label for="password">Password</label>
            <Password class="text-black" id="password" v-model="form.password" :feedback="false" />
            <Button class="bg-blue-500" label="Login" type="submit"></Button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    name: 'login',
    setup() {
        const form = ref({
            username: '',
            password: '',
        });
        const router = useRouter();

        const login = async () => {
            const response = await axios.post('http://localhost:8001/api/login', form.value);
            localStorage.setItem('sanctum_generated_token', response.data.access_token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
            router.push('/user-management');
        };

        return {
            form,
            login,
        };
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>