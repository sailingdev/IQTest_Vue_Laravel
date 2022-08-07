function initialState() {
    return {
        all: [],
        loading: false
    }
}

const getters = {
    allTests: state => state.all,
    total: state => state.all.length,
    loading: state => state.loading,
}

const actions = {
    fetchAllTest({ commit, state }) {
        commit('setLoading', true)
        axios.get('/api/v2/tests')
            .then(response => {
                commit('setAll', response.data.data)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    fetchData({ commit, state }, cId) {
        commit('setLoading', true)
        axios.get('/api/v2/getTests/' + cId)
            .then(response => {
                commit('setAll', response.data.data)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    setLoading({ commit }, value) {
        commit('setLoading', value);
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setAll(state, items) {
        state.all = items
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}