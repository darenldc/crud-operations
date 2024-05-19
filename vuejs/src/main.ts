import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from 'axios'

import PrimeVue from 'primevue/config'

import Password from 'primevue/password';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

import 'primevue/resources/themes/aura-light-green/theme.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(axios)
app.use(PrimeVue)

app.component('InputText', InputText)
app.component('Password', Password)
app.component('Button', Button)

app.mount('#app')
