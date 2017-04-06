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
import Dashboard from './components/views/Dashboard.vue'
import CreatePost from './components/views/CreatePost.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/login', component: Login },
    { path: '/posts/create', component: CreatePost },
]

const router = new VueRouter({
    base: '/admin',
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if (to.fullPath !== "/login") {
        axios.get('/api/profile').then(response => {
            next();
        }).catch(error => {
            router.push('/login');
        })
    } else {
        next();
    }
})

const app = new Vue({
    router,
    render: h => h(Admin)
}).$mount('#app');
