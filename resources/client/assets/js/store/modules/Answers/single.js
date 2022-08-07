function initialState() {
    return {
        item: {
            id: null,
            txt: null,
            img_url: null,
            img: null,
            result_text: null,
            score: null,
            question_id: null,
            created_at: null,
            updated_at: null,
            factors: null,
        },
        exceptField: ['created_at', 'updated_at'],
        languages: [],
        locale: 'en',
        loading: false,
        langLoading: false,
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
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {
            //    commit('setAnswerImage', result);
            if (state.item.txt == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (state.exceptField.indexOf(fieldName) != -1) {
                    continue;
                }
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



            axios.post('/api/v1/answers', params)
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
            //    commit('setAnswerImage', result);
            if (state.item.txt == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }

            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (state.exceptField.indexOf(fieldName) != -1) {
                    continue;
                }
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

            axios.post('/api/v1/answers/' + state.item.id, params)
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
            axios.get('/api/v1/answers/' + id + '?locale=' + state.locale)
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
    setAnswerText({ commit }, value) {
        commit('setAnswerText', value);
    },
    setAnswerImage({ commit }, value) {
        commit('setAnswerImage', value)
    },
    setAnswerScore({ commit }, value) {
        commit('setAnswerScore', value)
    },
    setResultText({ commit }, value) {
        commit('setResultText', value);
    },
    setQuestionId({ commit }, value) {
        commit('setQuestionId', value)
    },
    setCreatedAt({ commit }, value) {
        commit('setCreatedAt', value);
    },
    setUpdatedAt({ commit }, value) {
        commit('setUpdatedAt', value);
    },
    resetState({ commit }) {
        commit('resetState')
    },
    setLocale({ commit, state }, value) {
        commit('setLocale', value)
            //fetchData(state.item.id);
    },
    setFactorWeight({ commit }, value) {
        commit('setFactorWeight', value)
    },
    setImage({ commit }, value) {
        commit('setImage', value);
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setQuestionId(state, value) {
        state.item.question_id = Number(value);
    },
    setAnswerText(state, value) {
        state.item.txt = value;
    },
    setImage(state, value) {
        state.item.img = value;
    },
    setAnswerScore(state, value) {
        state.item.score = value;
    },
    setCreatedAt(state, value) {
        state.item.created_at = value;
    },
    setResultText(state, value) {
        state.item.result_text = value;
    },
    setUpdatedAt(state, value) {
        state.item.updated_at = value;
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        var tempId = state.item.question_id;
        state = Object.assign(state, initialState())
        state.item.question_id = tempId;
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
    setFactorWeight(state, value) {
        if (!state.item.factors) {
            return;
        }

        for (var i in state.item.factors) {
            state.item.factors[i].weight = Number(value[i]);
        }
        state.item.factors = JSON.stringify(state.item.factors);
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
};