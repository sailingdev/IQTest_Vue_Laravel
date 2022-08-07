function initialState() {
    return {
        item: {
            id: null,
            txt: null,
            img_url: null,
            img: null,
            correct_ans_exp: null,
            test_id: null,
            topic_id: 0,
            page: "normal",
            question_type: 0,
            // topic_name: null,
            answer_cnt: null,
            created_at: null,
            updated_at: null,
        },
        languages: [],
        topics: [],
        locale: 'en',
        defaultImgUrl: null,
        exceptField: ['answer_cnt', 'created_at', 'updated_at'],
        loading: false,
        langLoading: false,
        dataLoading: false,
        topicLoading: false
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    languages: state => state.languages,
    locale: state => state.locale,
    topics: state => state.topics
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)

        dispatch('Alert/resetState', null, { root: true });

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {

            //    commit('setQuestionImage', result);
            let params = new FormData();
            if (state.item.txt == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            if (state.item.page != 'normal' && state.item.topic_id == 0) {
                var errorMsg = 'You have to set key topic';
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



            axios.post('/api/v1/questions', params)
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
                //    });
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {
            //    commit('setQuestionImage', result);
            let params = new FormData();
            params.set('_method', 'PUT')
            if (state.item.txt == null && state.item.img == null) {
                var errorMsg = 'You have to set text or image!';
                dispatch(
                    'Alert/setAlert', { message: errorMsg, errors: null, color: 'danger' }, { root: true })
                commit('setLoading', false);
                reject(errorMsg);
                return;
            }
            if (state.item.page != 'normal' && state.item.topic_id == 0) {
                var errorMsg = 'You have to set key topic';
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

            axios.post('/api/v1/questions/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                        // dispatch('ImageFileInput/setImageUrl', state.item.img_url, { root: true })
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch(
                            'Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })
                        // dispatch('ImageFileInput/setImageUrl', state.item.img_url, { root: true })
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
            axios.get('/api/v1/questions/' + id + '?locale=' + state.locale)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve();
                    //dispatch('ImageFileInput/setImageUrl', response.data.data.img_url, { root: true });
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch('Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })
                        // dispatch('ImageFileInput/setImageUrl', state.item.img_url, { root: true })
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
    fetchKeyTopicData({ commit, state }) {
        commit('setTopicLoading', true)
        axios.get('/api/v1/topics')
            .then(response => {
                commit('setTopics', response.data.data)
            })
            .finally(() => {
                commit('setTopicLoading', false);
            })
    },
    setQuestionText({ commit }, value) {
        commit('setQuestionText', value);
    },
    setQuestionImage({ commit }, value) {
        commit('setQuestionImage', value);
    },
    clearImage({ commit }) {
        commit('clearImage')
    },
    setAnswerExplanation({ commit }, value) {
        commit('setAnswerExplanation', value)
    },
    setPageType({ commit }, value) {
        commit('setPageType', value);
    },
    setTopic({ commit }, value) {
        commit('setTopic', value);
    },
    setTestId({ commit }, value) {
        commit('setTestId', value)
    },
    setAnswerCnt({ commit }, value) {
        commit('setAnswerCnt', value);
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
    setQuestionType({ commit }, value) {
        commit('setQuestionType', value);
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
    setQuestionText(state, value) {
        state.item.txt = value;
    },
    setQuestionImage(state, value) {
        state.item.img = value;
    },
    setPageType(state, value) {
        state.item.page = value;
    },
    setImage(state, value) {
        state.item.img = value;
    },
    clearImage(state) {
        state.item.img_url = null;
        state.item.img = null;
    },
    setTopic(state, value) {
        state.item.topic_id = value;
    },
    setAnswerExplanation(state, value) {
        state.item.correct_ans_exp = value;
    },
    setAnswerCnt(state, value) {
        state.item.answer_cnt = value;
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
        var tempTopics = state.topics;
        state = Object.assign(state, initialState())
        state.item.test_id = tempId;
        state.topics = tempTopics;
    },
    setTopics(state, data) {
        state.topics = data;
    },
    setTopicLoading(state, loading) {
        if (loading) {
            state.loading = true;
        }
        state.topicLoading = loading;
        if (state.langLoading == false && state.dataLoading == false && state.topicLoading == false) {
            state.loading = false;
        }
    },
    setQuestionType(state, value) {
        state.item.question_type = value;
    },
    setLangLoading(state, loading) {
        if (loading) {
            state.loading = true;
        }
        state.langLoading = loading;
        if (state.langLoading == false && state.dataLoading == false && state.topicLoading == false) {
            state.loading = false;
        }
    },
    setDataLoading(state, loading) {
        if (loading) {
            state.loading = true;
        }
        state.dataLoading = loading;
        if (state.langLoading == false && state.dataLoading == false && state.topicLoading == false) {
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