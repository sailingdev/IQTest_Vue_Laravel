function initialState() {
    return {
        item: {
            id: null,
            title: null,
            description: null,
            time: null,
            instruction: null,
            category_id: null,
            pre_page_title: null,
            pre_page_desc: null,
            post_page_title: null,
            post_page_desc: null,
            post_question_cnt: null,
            pre_question_cnt: null,
            question_cnt: null,
            result_cnt: null,
            created_at: null,
            updated_at: null,
        },
        locale: 'en',
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading
}

const actions = {
    fetchData({ commit, state, dispatch }, id) {
        commit('setLoading', true)
        axios.get('/api/v2/tests/' + id + '?locale=' + state.locale)
            .then(response => {
                commit('setItem', response.data.data)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },

    setCategoryId({ commit }, value) {
        commit('setCategoryId', value);
    },

    resetState({ commit }) {
        commit('resetState')
    },
    setItemId({ commit }, id) {
        commit('setItemId');
    }

}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setItemId(state, id) {
        state.item.id = id;
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}