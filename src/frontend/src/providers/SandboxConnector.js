'use strict'

import axios from 'axios'
import store from '../../store'

let instance = null

class SandboxConnector {
  constructor () {
    if (!instance) {
      instance = this
    }
    return instance
  }

  get client () {
    switch (store.getters['user/getVersion'] || 7.3) {
      case '7.3':
        return axios.create({
          baseURL: process.env.APP_SANDBOX_BACKEND_URL_73
        })
      case '7.4':
        return axios.create({
          baseURL: process.env.APP_SANDBOX_BACKEND_URL_74
        })
    }
  }

  run (code) {
    return new Promise((resolve, reject) => {
      //  todo move to ENV
      this.client.post('/', {
        'code': code
      }).then(response => {
        resolve(response.data)
      }).catch(error => {
        console.log(error.response.data)
      })
    })
  }
}

export default SandboxConnector
