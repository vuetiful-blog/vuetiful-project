import Vue from 'vue';
import App from './components/App.vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)


import FrontPage from './components/views/FrontPage.vue'

const routes = [
    { path: '/', component: FrontPage },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
