<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center">{{ home }}</h2>
      </div>
      <div class="card-body">
        <h3 class="text-center text-danger">!Hello World!</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeComponent.vue",
  data() {
    this.$Progress.start();
    return {
      home: "welcome home page",
    };
    this.$Progress.finish();
  },
};
</script>
