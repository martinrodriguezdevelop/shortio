import './bootstrap';
import {createApp} from 'vue'
import { createPinia } from 'pinia'
import router from './src/router'

import App from './src/App.vue'

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
app.use(router)

app.mount("#app")