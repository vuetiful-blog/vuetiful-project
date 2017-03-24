import Vue from 'vue';
import Admin from './components/Admin.vue';
import Axios from 'axios';
import VueRouter from 'vue-router';
import Velocity from 'velocity-animate';
Vue.use(VueRouter)

window.axios = Axios;
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import Login from './components/views/Login.vue'


const routes = [
    { path: '/login', component: Login },
]

const router = new VueRouter({
	base: '/admin',
    mode: 'history',
    routes
})

const app = new Vue({
    router,
    render: h => h(Admin)
}).$mount('#app');
