function initialState() {
    return {
        item: {
            id: null,
            category_id: null,
            pre_page_title: null,
            pre_page_desc: null,
            post_page_title: null,
            post_page_desc: null,
            pre_question_cnt: null,
            post_question_cnt: null
        },
        languages: [],
        locale: 'en',
        exceptField: ['category_id'],
        loading: false,
        langLoading: false,
        dataLoading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    languages: state => state.languages,
    exceptField: state => state.exceptField,
    locale: state => state.locale,
    langLoading: state => state.langLoading
}

const actions = {
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {

                if (state.exceptField.indexOf(fieldName) != -1) {
                    continue;
                }
                console.log(fieldName);
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }
            params.set('locale', state.locale);

            axios.post('/api/v1/tests/' + state.item.id, params)
                .then(response => {
                    // commit('setItem', response.data.data)
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch(
                        'Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    fetchData({ commit, state, dispatch }, id) {
        commit('setDataLoading', true)
        commit('setItem', initialState().item);
        axios.get('/api/v1/tests/' + id + '/page?locale=' + state.locale)
            .then(response => {
                commit('setItem', response.data.data)
            })
            .finally(() => {
                commit('setDataLoading', false)
            })
    },
    fetchLanguageData({ commit, state }) {
        commit('setLangLoading', true)
        axios.get('/api/v1/languages')
            .then(response => {
                commit('setLanguages', response.data.data)
            })
            .finally(() => {
                commit('setLangLoading', false);
            })
    },

    setCategoryId({ commit }, value) {
        commit('setCategoryId', value);
    },

    setPrePageTitle({ commit }, value) {
        commit('setPrePageTitle', value);
    },
    setPrePageDescription({ commit }, value) {
        commit('setPrePageDescription', value);
    },
    setPostPageTitle({ commit }, value) {
        commit('setPostPageTitle', value);
    },
    setPostPageDescription({ commit }, value) {
        commit('setPostPageDescription', value);
    },

    resetState({ commit }) {
        commit('resetState')
    },
    setItemId({ commit }, id) {
        commit('setItemId');
    },
    setLocale({ commit, state }, value) {
        commit('setLocale', value)
            //fetchData(state.item.id);
    },

}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setCategoryId(state, value) {
        state.item.category_id = Number(value);
    },

    setPrePageTitle(state, value) {
        state.item.pre_page_title = value;
    },
    setPrePageDescription(state, value) {
        state.item.pre_page_desc = value;
    },
    setPostPageTitle(state, value) {
        state.item.post_page_title = value;
    },
    setPostPageDescription(state, value) {
        state.item.post_page_desc = value;
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setItemId(state, id) {
        state.item.id = id;
    },
    setLangLoading(state, loading) {
        if (loading) {
            state.loading = true;
        }
        state.langLoading = loading;
        if (state.langLoading == false && state.dataLoading == false) {
            state.loading = false;
        }
    },
    setDataLoading(state, loading) {
        if (loading) {
            state.loading = true;
        }
        state.dataLoading = loading;
        if (state.langLoading == false && state.dataLoading == false) {
            state.loading = false;
        }
    },
    setLanguages(state, value) {
        state.languages = value;
    },
    setLocale(state, value) {
        state.locale = value;
    },
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}