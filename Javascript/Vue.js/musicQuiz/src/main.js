import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueRouter from 'vue-router'

import VueFire from 'vuefire'
import firebase from 'firebase/app'
import 'firebase/firestore'

import App from './App.vue'
import responsive from 'vue-responsive'

Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.use(VueFire)
Vue.use(responsive)

firebase.initializeApp({
  projectId: 'musicquiz-3e9f4',
  databaseURL: 'https://musicquiz-3e9f4.firebaseio.com'
})
export const db = firebase.firestore()
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
