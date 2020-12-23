import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import event from './event'
import error from './error'
import message from './message'
import search from './search'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    event,
    message,
    error,
    search
  }
})

export default store