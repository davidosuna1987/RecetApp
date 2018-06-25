require('./src/bootstrap');

window.Vue = require('vue');

window.trans = (string) => _.get(window.i18n, string);
// Vue.prototype.trans = string => _.get(window.i18n, string);
Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

// Libraries
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

import lineClamp from 'vue-line-clamp';
Vue.use(lineClamp, {
  // plugin options (show in https://github.com/Frondor/vue-line-clamp)
});

// Components
Vue.component('recipe-form', require('./components/RecipeForm.vue'));
Vue.component('recipe-list', require('./components/RecipeList.vue'));
Vue.component('recipe-card', require('./components/RecipeCard.vue'));

// Instance
const app = new Vue({
    el: '#app',

    data() {
      return {
        authuser: {}
      }
    },

    methods: {
      getAuthuser() {
        axios.get('/authuser').then(response => {
          this.authuser = response.data.authuser;
        }).catch(error => {
          if(error.response && error.response.status && error.response.status === 419)
            location.href = '/login';

          console.info(error);
        });
      }
    },

    mounted() {
      this.getAuthuser();
    }
});

require('./src/autoload');
