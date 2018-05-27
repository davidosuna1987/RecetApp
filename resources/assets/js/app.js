require('./src/bootstrap');
window.Vue = require('vue');

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

Vue.component('recipe-form', require('./components/RecipeForm.vue'));

const app = new Vue({
    el: '#app'
});

require('./src/autoload');
