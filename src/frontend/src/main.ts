import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

Vue.config.productionTip = false

require('./mystyles.scss')
// eslint-disable-next-line @typescript-eslint/no-var-requires
Vue.use(require('vue-shortkey'))
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
