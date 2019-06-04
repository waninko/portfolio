import Vue from 'vue'
import Router from 'vue-router'
import ShowMusic from '@/components/ShowMusic'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'ShowMusic',
      component: ShowMusic
    }
  ]
})
