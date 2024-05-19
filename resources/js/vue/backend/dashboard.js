require('./plugins/axios_setup');
require('./plugins/moment_setup');
require('./plugins/preview_image');
require('./plugins/auto_logout');
require('./plugins/preloader');
require('./plugins/csv_to_array');
require('./plugins/demo_data_load');
require('./plugins/get_selector_form_data');
require('./plugins/set_selector_form_data');
require('./plugins/ck_editor_config');
require('./plugins/remove_product_image');

window.debounce = require('debounce');
window.CsvBuilder = require('filefy').CsvBuilder;

/*********************
   dashboard vue setup
**********************/

import Vue from 'vue'
import router from './router/router';
import store from './store/index';

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('input-field', require('./views/components/InputField.vue').default);
Vue.component('user-management-modal', require('./views/users/components/UserManagementModal.vue').default);
Vue.component('ex-app', require('./App.vue').default);
Vue.prototype.kebabize = str => {
    return str.split('').map((letter, idx) => {
      return letter.toUpperCase() === letter
       ? `${idx !== 0 ? '-' : ''}${letter.toLowerCase()}`
       : letter;
    }).join('');
}
Vue.prototype.camelToNormal = str => {
    return str.split('').map((letter, idx) => {
      return letter.toUpperCase() === letter
       ? `${idx !== 0 ? ' ' : ''}${letter.toLowerCase()}`
       : letter;
    }).join('');
}

if (document.getElementById('app')) {
    window.vue = new Vue({
        store,
        router,
        el: '#app',
        created: function () {
            console.log('dashboard started');
        },
    })
}
