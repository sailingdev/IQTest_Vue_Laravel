function initialState() {
    return {
        item: {
            id: null,
            title: null,
            formula: 0,
            img_url: null,
            img: null,
            description: null,
            test_id: null,
            created_at: null,
            updated_at: null,
        },
        languages: [],
        locale: 'en',
        defaultImgUrl: null,
        exceptField: ['created_at', 'updated_at'],
        loading: false,
        langLoading: false,
        dataLoading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    languages: state => state.languages,
    locale: state => state.locale,
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)

        dispatch('Alert/resetState', null, { root: true });

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {

            //    commit('setFactorImage', result);
            let params = new FormData();
            if (state.item.title == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
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



            axios.post('/api/v1/factors', params)
                .then(response => {
                    commit('resetState')
                        //dispatch('ImageFileInput/clearImage', null, { root: true });
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
            //    commit('setFactorImage', result);
            let params = new FormData();
            params.set('_method', 'PUT')
            if (state.item.title == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
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

            axios.post('/api/v1/factors/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                        //dispatch('ImageFileInput/setImageUrl', state.item.img_url, { root: true })
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch(
                            'Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })
                        //dispatch('ImageFileInput/setImageUrl', state.item.img_url, { root: true })
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
            axios.get('/api/v1/factors/' + id + '?locale=' + state.locale)
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

    setFactorTitle({ commit }, value) {
        commit('setFactorTitle', value);
    },
    setFormula({ commit }, value) {
        commit('setFormula', value);
    },
    setFactorImage({ commit }, value) {
        commit('setQuestionImage', value);
    },
    clearImage({ commit }) {
        commit('clearImage')
    },
    setFactorDescription({ commit }, value) {
        commit('setFactorDescription', value)
    },
    setTestId({ commit }, value) {
        commit('setTestId', value)
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
    setTestId(state, value) {
        state.item.test_id = Number(value);
    },
    setFactorTitle(state, value) {
        state.item.title = value;
    },
    setFactorImage(state, value) {
        state.item.img = value;
    },
    setImage(state, value) {
        state.item.img = value;
    },
    setFormula(state, value) {
        state.item.formula = value;
    },
    clearImage(state) {
        state.item.img_url = null;
        state.item.img = null;
    },
    setFactorDescription(state, value) {
        state.item.description = value;
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
        var tempId = state.item.test_id;
        state = Object.assign(state, initialState())
        state.item.test_id = tempId;
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