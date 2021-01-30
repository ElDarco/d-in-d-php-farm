import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'Welcome',
    component: () => import(/* webpackChunkName: "about" */ '../views/Welcome.vue')
  },
  {
    path: '/mock-server',
    name: 'MockServer',
    component: () => import(/* webpackChunkName: "about" */ '../views/MockServer.vue')
  },
  {
    path: '/php',
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
