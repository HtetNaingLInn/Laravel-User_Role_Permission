import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Home from "./components/HomeComponent.vue";
import User from "./components/UserComponent.vue";

export default new Router({
    routes: [{
            path: "/",
            component: Home
        },
        {
            path: "/user",
            component: User
        }
    ]
});