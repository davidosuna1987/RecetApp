require('./src/bootstrap');


window.Vue = require('vue');

window.trans = (string) => _.get(window.i18n, string);
Vue.prototype.trans = string => _.get(window.i18n, string);

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

Vue.component('recipe-form', require('./components/RecipeForm.vue'));
Vue.component('recipe-list', require('./components/RecipeList.vue'));
Vue.component('recipe-card', require('./components/RecipeCard.vue'));

const app = new Vue({
    el: '#app'
});

require('./src/autoload');
