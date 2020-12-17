import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'


const state = {
    cities: null,
    apiStatus: null,
    loginErrorMessages: null,
    registerErrorMessages: null,
}

const getters = {
    check: state => !! state.cities,
    cities: state => state.cities
}

const mutations = {
    setCities (state, cities) {
        state.cities = cities
    },
    setApiStatus (state, status) {
        state.apiStatus = status
    },
}

const actions = {
    async store (context, data) {
        await context.commit('setCities', data)
    },


    async search (context, data) {
        context.commit('setApiStatus', null)
        const response = await axios.post(
                '/api/login', data
            ).catch(
                err => err.response || err
            )

        if(response.status === OK) {
            context.commit('setApiStatus', true)
            context.commit('setUser', response.data)
            return false
        }

        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setLoginErrorMessages', response.data.errors)
        } else {
            context.commit('error/setCode', response.status, { root: true })
        }
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}