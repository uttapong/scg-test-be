import Vue from "vue/dist/vue.esm.js";
import Index from "./Index.vue";
import Restaurant from "./Restaurant.vue";
import VueRouter from "vue-router";
import BootstrapVue from "bootstrap-vue";

Vue.config.productionTip = false;
Vue.use(VueRouter);
Vue.use(BootstrapVue);

const router = new VueRouter({
  routes: [
    { path: "/SCG", component: Index }
    // { path: "/", component: Restaurant }
  ]
});

new Vue({
  router
}).$mount("#app");
