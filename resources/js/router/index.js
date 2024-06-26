import { createWebHistory , createRouter } from 'vue-router';

import Store from '../pages/Store.vue';
import Pos from '../pages/Pos.vue';
import Transection from '../pages/Transection.vue';
import Report from '../pages/Report.vue';
import Nopage from '../pages/Nopage.vue';
import Login from '../pages/login.vue';
import Register from '../pages/Register.vue';

import { useStore } from '../store/auth';

//middleware

const authMiddleware = (to, from, next) => {
    const token = localStorage.getItem("web_token");
    const user = localStorage.getItem("web_user");
    const store = useStore();

    if(!token){
        next({
            path:"/login",
            replace: true
        });
    }else{

        //ຂຽນຂໍ້ມູນເຂົ້າ  pinia store
        store.set_token(token);
        store.set_user(user);
        next();
    }


}

export const routes = [
    {
        path: '/',
        redirect: '/store'
    },
    {
        name: 'store',
        path: '/store',
        component: Store,
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name: 'pos',
        path: '/pos',
        component: Pos,
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name: 'transection',
        path: '/transection',
        component: Transection,
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name: 'report',
        path: '/report',
        component: Report,
        meta:{
            middleware: [authMiddleware]
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'nopage',
        path: '/:pathMatch(.*)*',
        component: Nopage,
        meta:{
            middleware: [authMiddleware]
        }
    }
];

const router = createRouter({
    history: createWebHistory (),
    routes: routes,
    scrollBehavior(){
        window.scroll(0,0)
    }
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("web_token");
    if(to.meta.middleware){
        to.meta.middleware.forEach(middleware => middleware(to,from,next))
    }else{
        if(to.path == "/login" || to.path == "/"){
            if(token){
                next({
                    path:"/store",
                    replace: true
                });
            }else{
                next();
            }
        }else{
            next();
        }
    }
});

export default router;