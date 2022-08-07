function initialState() {
    return {
        item: {
            id: null,
            title: null,
            description: null,
            question: null,
            short_desc: null,
            test_type: 1,
            type_name: null,
        },
        languages: [],
        types: [],

        loading: false,
        langLoading: false,
        dataLoading: false,
        locale: 'en',
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    languages: state => state.languages,
    types: state => state.types,
    locale: state => state.locale

}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
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
            //params.set('locale', state.locale);


            axios.post('/api/v1/categories', params)
                .then(response => {
                    commit('resetState')
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
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
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

            axios.post('/api/v1/categories/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
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
    fetchData({ commit, state }, id) {
        commit('setDataLoading', true)
        commit('setItem', initialState().item);
        axios.get('/api/v1/categories/' + id + '?locale=' + state.locale)
            .then(response => {
                commit('setItem', response.data.data)
            })
            .finally(() => {
                commit('setDataLoading', false)
            })
    },
    fetchInitialData({ commit, state }) {
        commit('setLangLoading', true)
        axios.get('/api/v1/getInitialData')
            .then(response => {
                commit('setLanguages', response.data.data.language)
                commit('setTypes', response.data.data.type)
            })
            .finally(() => {
                commit('setLangLoading', false);
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

    setTitle({ commit }, value) {
        commit('setTitle', value)
    },
    setQuestion({ commit }, value) {
        commit('setQuestion', value);
    },
    setShortDescription({ commit }, value) {
        commit('setShortDescription', value);
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
    setLocale({ commit, state }, value) {
        commit('setLocale', value)
            //fetchData(state.item.id);
    },
    setType({ commit }, value) {
        commit('setType', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setTitle(state, value) {
        state.item.title = value
    },
    setQuestion(state, value) {
        state.item.question = value;
    },
    setShortDescription(state, value) {
        state.item.short_desc = value
    },
    setDescription(state, value) {
        state.item.description = value
    },
    setType(state, value) {
        state.item.test_type = value;
    },
    setLanguages(state, value) {
        state.languages = value;
    },
    setTypes(state, value) {
        state.types = value;
    },
    setLocale(state, value) {
        state.locale = value;
    },

    setLoading(state, loading) {
        state.loading = loading
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