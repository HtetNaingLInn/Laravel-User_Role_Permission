import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Home from "./components/HomeComponent.vue";
import User from "./components/UserComponent.vue";
import Role from "./components/RoleComponent.vue";
import Permission from "./components/PermissionComponent.vue";

export default new Router({
    routes: [{
            path: "/",
            component: Home
        },
        {
            path: "/user",
            component: User
        },
        {
            path: "/role",
            component: Role
        },
        {
            path: "/permission",
            component: Permission
        }
    ]
});