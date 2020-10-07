<template>
    <div class="container">
        <h1>{{ home }}</h1>
    </div>
</template>

<script>
export default {
    name: "HomeComponent.vue",
    data() {
        return {
            home: "welcome home page"
        };
    }
};
</script>
