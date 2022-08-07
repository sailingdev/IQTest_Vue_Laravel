function initialState() {
    return {
        item: {
            id: null,
            title: null,
            min_score: null,
            max_score: null,
            img_url: null,
            img: null,
            description: null,
            factor_id: null,
            created_at: null,
            updated_at: null,
        },
        languages: [],
        locale: 'en',
        defaultImgUrl: null,
        exceptField: ['created_at', 'updated_at'],
        loading: false,
        angLoading: false,
        dataLoading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    languages: state => state.languages,
    locale: state => state.locale
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)

        dispatch('Alert/resetState', null, { root: true });

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {
            //    console.log(result);
            //    commit('setResultImage', result);
            let params = new FormData();
            if (state.item.title == null && state.item.img == null) {
                var errorMsg = 'You have to set title or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            if (state.item.min_score >= state.item.max_score) {
                var errorMsg = 'Min score must be less than max score';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }

            for (let fieldName in state.item) {
                if (state.exceptField.indexOf(fieldName) != -1) {
                    continue;
                }
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



            axios.post('/api/v1/factorResults', params)
                .then(response => {
                    commit('resetState')
                    dispatch('ImageFileInput/clearImage', null, { root: true });
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
                //});
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {
            //    commit('setResultImage', result);
            let params = new FormData();
            params.set('_method', 'PUT')
            if (state.item.title == null && state.item.img == null) {
                var errorMsg = 'You have to set title or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            if (state.item.min_score >= state.item.max_score) {
                var errorMsg = 'Min score must be less than max score';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            for (let fieldName in state.item) {
                if (state.exceptField.indexOf(fieldName) != -1) {
                    continue;
                }

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

            axios.post('/api/v1/factorResults/' + state.item.id, params)
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
                //});
        })
    },
    fetchData({ commit, dispatch, state }, id) {
        commit('setDataLoading', true)
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/factorResults/' + id + '?locale=' + state.locale)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve()
                        //dispatch('ImageFileInput/setImageUrl', response.data.data.img_url, { root: true });
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch('Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setDataLoading', false)
                })
        });



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
    setMinScore({ commit }, value) {
        commit('setMinScore', value);
    },
    setMaxScore({ commit }, value) {
        commit('setMaxScore', value);
    },
    setDescription({ commit }, value) {
        commit('setDescription', value);
    },
    setTitle({ commit }, value) {
        commit('setTitle', value);
    },
    setResultImage({ commit }, value) {
        commit('setResultImage', value);
    },
    clearImage({ commit }) {
        commit('clearImage')
    },

    setFactorId({ commit }, value) {
        commit('setFactorId', value)
    },

    setCreatedAt({ commit }, value) {
        commit('setCreatedAt', value);
    },
    setUpdatedAt({ commit }, value) {
        commit('setUpdatedAt', value);
    },
    setLocale({ commit, state }, value) {
        commit('setLocale', value)
            //fetchData(state.item.id);
    },
    resetState({ commit }) {
        commit('resetState')
    },
    setImage({ commit }, value) {
        commit('setImage', value);
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item;
    },
    setFactorId(state, value) {
        state.item.factor_id = Number(value);
    },

    setResultImage(state, value) {
        state.item.img = value;
    },
    setImage(state, value) {
        state.item.img = value;
    },
    clearImage(state) {
        state.item.img_url = null;
        state.item.img = null;
    },
    setMinScore(state, value) {
        state.item.min_score = value;
    },
    setMaxScore(state, value) {
        state.item.max_score = value;
    },
    setDescription(state, value) {
        state.item.description = value;
    },
    setTitle(state, value) {
        state.item.title = value;
    },
    setCreatedAt(state, value) {
        state.item.created_at = value;
    },
    setUpdatedAt(state, value) {
        state.item.updated_at = value;
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        var tempId = state.item.factor_id;
        state = Object.assign(state, initialState())
        state.item.factor_id = tempId;
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