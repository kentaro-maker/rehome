import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import message from './message'
import regions from './regions'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    message,
    error,
    regions
  }
})

export default store