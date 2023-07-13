import Vue from 'vue'  // <--- should be 'vue' NOT 'Vue'
import VueRouter from 'vue-router'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

// project pages
import home from './components/pages/home'
import tags from './components/pages/tags'
Vue.use(VueRouter)


const routes = [
    //projects routes....

    {
        path: '/',
        component: home,

    },
    {
        path: '/tags',
        component: tags,

    },




    /// basic tutorials routes...

    {
        path: '/new-route',
        component: newRoutePage
    },
    // vue hooks
    {
        path: '/hooks',
        component: hooks
    },
    // more basics
    {
        path: '/methods',
        component: methods
    },
]
const router = new VueRouter(
    {
        routes,
        hashbang : false,
        mode : 'history'
    }
    )

    export default router
