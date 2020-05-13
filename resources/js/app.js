
require('./bootstrap');

import router from "./routes";
import VueRouter from "vue-router";
import index from "./index";
import  moment from "moment";
import StarRating from "./shared/components/StarRating";

window.Vue = require('vue');



// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueRouter);

Vue.filter("fromNow",value => moment(value).fromNow());

Vue.component("star-rating",StarRating);


const app = new Vue({
    el: '#app',
    router,
    components:{
        "index":index
    }
});
