function initialState() {
    return {
        item: {
            score: null,
            totalQuestions: null,
            successQuestions: null,
            failedQuestions: null,
            notAnswersQuestions: null,
            canDownload: false
        },
        loading: false,

    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
}

const actions = {
    fetchData({ commit, state }, token) {
        commit('resetState')
        commit('setLoading', true)
        return new Promise((resolve, reject) => {
            axios.get('/api/v2/test/' + token + '/result')
                .then(response => {
                    console.log(response.data.data);
                    commit('setItem', response.data.data)
                    setTimeout(function() {
                        resolve()
                    }, 500);

                })
                .catch(error => {
                    alert("Error!");
                    console.log(error);
                    reject()
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })

    },
}

const mutations = {
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setLoading(state, value) {
        state.loading = value
    },
    setItem(state, value) {
        state.item = value;
    },
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}