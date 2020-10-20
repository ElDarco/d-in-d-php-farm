const state = {
  nightmode: false,
  columnmode: false,
  code: '<?php',
  version: '7.3'
}

const getters = {
  getNightMode (state, getters) {
    return state.nightmode
  },
  getVersion (state, getters) {
    return state.version
  },
  getColumnMode (state, getters) {
    return state.columnmode
  },
  getCode (state, getters) {
    return state.code
  }
}

const actions = {
  saveNightMode (context, nightmode) {
    context.commit('setNightMode', nightmode)
  },
  saveColumnMode (context, columnmode) {
    context.commit('setColumnMode', columnmode)
  },
  saveSetCode (context, code) {
    context.commit('setCode', code)
  },
  saveVersion (context, version) {
    context.commit('setVersion', version)
  }
}

const mutations = {
  setNightMode (state, nightmode) {
    state.nightmode = nightmode
  },
  setColumnMode (state, columnmode) {
    state.columnmode = columnmode
  },
  setCode (state, code) {
    state.code = code
  },
  setVersion (state, version) {
    state.version = version
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
