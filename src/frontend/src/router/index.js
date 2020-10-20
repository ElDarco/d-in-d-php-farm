import Vue from 'vue'
import Router from 'vue-router'
import MainPage from '@/components/page/main/MainPage'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'MainPage',
      component: MainPage
    }
  ]
})
export default router
