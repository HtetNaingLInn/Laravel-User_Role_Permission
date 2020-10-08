require("./bootstrap");

window.Vue = require("vue");
import Vue from "vue";
import router from "./router";
import { Form, HasError, AlertError } from "vform";
import Swal from "sweetalert2/dist/sweetalert2.js";

Vue.component("pagination", require("laravel-vue-pagination"));
Vue.component("app-component", require("./components/layouts/app.vue").default);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

window.Form = Form;
window.Swal = Swal;
const app = new Vue({
    el: "#app",
    router
});