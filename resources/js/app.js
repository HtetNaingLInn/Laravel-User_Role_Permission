require("./bootstrap");

window.Vue = require("vue");
import Vue from "vue";
import router from "./router";
import { Form, HasError, AlertError } from "vform";
import Swal from "sweetalert2/dist/sweetalert2.js";
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: '#38c172',
    failedColor: 'red',
    height: '2px',
    thickness: '2px',
    transition: {
        speed: '0.8s',
        opacity: '0.2s',
        termination: 500
    },
})



window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
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