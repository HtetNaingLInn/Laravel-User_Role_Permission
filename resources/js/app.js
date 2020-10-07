require("./bootstrap");

window.Vue = require("vue");

Vue.component(
    "home-component",
    require("./components/HomeComponent.vue").default
);

const app = new Vue({
    el: "#app"
});