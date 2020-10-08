<template>
    <div class="container">
        <ul class="nav justify-content-center">
            <li class="nav-item mr-4">
                <router-link to="/">
                    <button class="btn btn-primary btn-sm">Home</button>
                </router-link>
            </li>
            <li class="nav-item  mr-4">
                <router-link to="/user">
                    <button class="btn btn-primary btn-sm">User</button>
                </router-link>
            </li>
            <li class="nav-item  mr-4">
                <router-link to="/role">
                    <button class="btn btn-primary btn-sm">Role</button>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/permission">
                    <button class="btn btn-primary btn-sm">permission</button>
                </router-link>
            </li>
        </ul>
        <hr />
        <router-view />
    </div>
</template>
