import Vue from "vue"
import VueRouter from "vue-router"
import UserRegister from "./views/User/Register"
import UserLogin from "./views/User/Login"
import Home from "./views/Home"
import TaskNew from "./views/Task/New"
import store from "./store"

Vue.use(VueRouter)

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/user/register",
            name: "user-register",
            component: UserRegister
        },
        {
            path: "/user/login",
            name: "user-login",
            component: UserLogin
        },
        {
            path: "/task/new",
            name: "task-new",
            component: TaskNew,
            meta: {
                requiresAuth: true
            }
        }
    ]
})

router.beforeEach((to, _, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters["login/loggedIn"]) {
            return next()
        }

        return next("/user/login")
    }

    next()
})

export default router
