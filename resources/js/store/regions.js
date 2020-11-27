

const state = {
    regions: null,
}

const getters = {
    regions: state => {
        return state.regions
    }
}

const mutations = {
    setRegions (state, regions) {
        state.regions = regions
    },

}

const actions = {
    register (context, data) {
        context.commit('setRegions', data)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}