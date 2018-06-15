
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.E = require('wangeditor')
window.Velocity = require('velocity-animate');
window.Swal = require('sweetalert2');
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
//Article作为组件名不好使，，不知道为什么 文章列表组件
import Article from './components/Article.vue';
Vue.component('articlelist',Article);

import ArticleDetail  from './components/ArticleDetail.vue';
Vue.component('adetail',ArticleDetail);
Vue.component('comment-article',require('./components/comment-article.vue'));

//注册修改文章组件
Vue.component('article-edit',require('./components/article-edit.vue'));