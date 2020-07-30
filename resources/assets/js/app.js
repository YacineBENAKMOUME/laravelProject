
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue'); 
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';


import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;


const Toast = swal.mixin({
  Toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (Toast) => {
    Toast.addEventListener('mouseenter', swal.stopTimer)
    Toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});
window.Toast = Toast; 

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));



import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})  

let routes = [
  { path: '/users', component: require('./components/users.vue') },
  { path: '/etranger', component: require('./components/etranger.vue') },
  { path: '/formation', component: require('./components/formation.vue') },
  { path: '/relex', component: require('./components/relex.vue') },
  { path: '/dashboard', component: require('./components/dashboard.vue') },
  { path: '*', component: require('./components/NotFound.vue') }
]

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})

Vue.filter('upText', function(text){
  return text.charAt(0).toUpperCase() + text.slice(1)
}); 

Vue.filter('MyDate',function(created){
    return moment(created).format("MMM DO YY");
});

window.Fire = new Vue();


Vue.component(
  'not-found',
  require('./components/NotFound.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router,
    data:{
       search: ''
    },

    methods:{
      searchit: _.debounce(() => {
        Fire.$emit('searching');

      },1000)
    }
});
 