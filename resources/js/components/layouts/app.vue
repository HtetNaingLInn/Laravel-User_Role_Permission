<template>
    <div class="container">
        <ul class="list">
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/user">User</router-link></li>
        </ul>
        <router-view />
    </div>
</template>
