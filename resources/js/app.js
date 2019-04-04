
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');
import VModal from 'vue-js-modal';
import VeeValidate, { Validator }  from 'vee-validate';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import ru from 'vee-validate/dist/locale/ru';

Vue.use(VModal,{dynamic: true, injectModalsContainer: true });

Vue.use(VeeValidate);

// Localize takes the locale object as the second argument (optional) and merges it.
Validator.localize('ru', ru);

Vue.use(Loading);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 *
 *  */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('map-component', require('./components/MapComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const main = new Vue({
    el: '#main'
});
