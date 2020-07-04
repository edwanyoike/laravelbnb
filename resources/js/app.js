import router from './routes';
import VueRouter from 'vue-router';
import index from './index';
import moment from 'moment';
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';
import ValidationErrors from './shared/components/ValidationErrors';
import Success from './shared/components/Success';
import storeDefinition from './store';

import Vuex from 'vuex';

require('./bootstrap');


window.Vue = require('vue');


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueRouter);
Vue.use(Vuex);


Vue.filter('fromNow', value => moment(value).fromNow());

Vue.component('star-rating', StarRating);
Vue.component('fatal-error', FatalError);
Vue.component('success', Success);
Vue.component('v-errors', ValidationErrors);

const store = new Vuex.Store(storeDefinition);

window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if(error.response.status === 401){
            store.dispatch('logout');
        }

        return Promise.reject(error);
    }
);


const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        'index': index
    },
    beforeCreate() {
        this.$store.dispatch('loadStoredState');
        this.$store.dispatch('loadUser');
    }
});
