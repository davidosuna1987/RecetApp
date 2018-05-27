require('./src/bootstrap');

window.Vue = require('vue');

Vue.component('recipe-form', require('./components/RecipeForm.vue'));

const app = new Vue({
    el: '#app'
});

require('./src/autoload');
