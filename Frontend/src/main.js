import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router' // Import router yang udah dibikin tadi

const app = createApp(App)

app.use(router) // Pasang plugin router ke Vue
app.mount('#app')