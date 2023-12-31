require('./bootstrap');
window.Vue = require('vue').default;
import  store  from './store';
import router from './router';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common';
import JsonToHtml from './JsonToHtml';
Vue.mixin(common);
Vue.mixin(JsonToHtml)
Vue.use(ViewUI);
import Editor from 'vue-editor-js'

Vue.use(Editor)


Vue.component('mainapp', require('./components/mainapp.vue').default)
 new Vue({
    el: '#app',
    router,
    store


})
