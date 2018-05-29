
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.E = require('wangeditor')
window.Velocity = require('velocity-animate');
import VueRouter from 'vue-router';
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//引入发布文章、问题组件
import Release from './components/Release.vue'
//组件引用
const release = new Vue({
	el:'#re',
	components:{ Release},
	template:'<Release/>'
})
