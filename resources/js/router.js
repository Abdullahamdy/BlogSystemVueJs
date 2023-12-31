import Vue from 'vue'  // <--- should be 'vue' NOT 'Vue'
import VueRouter from 'vue-router'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

// project pages
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import notfound from './admin/pages/notfound'
import adminusers from './admin/pages/adminusers'
import login from './admin/pages/Login.vue'
import role from './admin/pages/role.vue'
import assignRole from './admin/pages/assignRole.vue'
import createblogs from './admin/pages/createblog.vue'
import editblog from './admin/pages/editblog.vue'
import blogs from './admin/pages/blogs.vue'
Vue.use(VueRouter)


const routes = [
    //projects routes....

    {
        path: '/',
        component: home,
        name: 'home',

    },
    {
        path: '*',
        component: notfound,
        name: 'notfound'

    },
    {
        path: '/login',
        component: login,
        name: 'login'

    },

    {
        path: '/tags',
        component: tags,
        name: 'tags',


    },
    {
        path: '/role',
        component: role,
        name: 'role',


    },
    {
        path: '/assignRole',
        component: assignRole,
        name:'assignRole'

    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers',


    },
    {
        path: '/category',
        component: category,
        name: category,

    },
    {
        path: '/createblogs',
        component: createblogs,
        name: createblogs,

    },
    {
        path: '/editblog/:id',
        component: editblog,
        name: editblog,

    },
    {
        path: '/blogs',
        component: blogs,
        name: blogs,

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
        mode : 'history',
    }
    )

    export default router
