import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/welcome',
    name: 'Welcome',
    component: () => import(/* webpackChunkName: "about" */ '../views/Welcome.vue')
  },
  {
    path: '/',
    name: 'Environment',
    component: () => import(/* webpackChunkName: "about" */ '../views/Environment.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
