require('./bootstrap')
// import '../scss/app.scss'

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
import Chat from 'vue-beautiful-chat'
import {routes} from './routes'
import StoreData from './store'
import MainApp from './components/MainApp.vue';


Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(VModal, { dialog: true })
Vue.use(Chat)

const store = new Vuex.Store(StoreData)

const router = new VueRouter({
  routes,
  mode: 'history'
})

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}


const app = new Vue({
  el: '#app',
  router,
  store,
  components: {
    MainApp
  }
})
