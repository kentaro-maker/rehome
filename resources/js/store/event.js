import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'


const state = {
    apiStatus: null,
    createErrorMessages: null,
}

const getters = {
}

const mutations = {
    setApiStatus (state, status) {
        state.apiStatus = status
    },
    setCreateErrorMessages (state, messages) {
        state.createErrorMessages = messages
    },
}

const actions = {
    async create (context, data) {
        
        context.commit('setApiStatus', null)
        const response = await axios.post(
                    '/api/event/create', data
                ).catch(
                    err => err.response || err
                )
        
        if (response.status === CREATED) {
            context.commit('setApiStatus', true)
            return false
        }
        console.log(response)
        context.commit('setApiStatus', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit('setCreateErrorMessages', response.data.errors)
            console.log("UNPROCESSABLE")
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