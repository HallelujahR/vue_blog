
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.E = require('wangeditor')
window.Velocity = require('velocity-animate');
window.Swal = require('sweetalert2');
// window.VueRouter = require("vue-router");
window.Vue = require('vue');
import VueRouter from 'vue-router'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter)

//引入发布文章、问题组件
import Release from './components/Release.vue';
import Question from './components/Question.vue';
Vue.component('Release',Release);
Vue.component('Question',Question);
new Vue({
	el:'#Release',
	data:{
		show:true,
	},
	methods:{
		test:function(){
			this.show = true;
		},
		test1:function(){
			this.show = false;
		}
	},



});

// Vue.component('example', require('./components/Article.vue'));
import Example from './components/Article.vue'

const routes = [
  { path: '/article', component: Example },
]

const router = new VueRouter({
  routes // (缩写) 相当于 routes: routes
})

const app = new Vue({
  router
}).$mount('#imp')