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
            factor_cnt: null,
            result_cnt: null,
            created_at: null,
            updated_at: null,
            extra_file: null,
            extra_file_url: null,
            certification_file: null,
            certification_file_url: null,
            certification_img_url: null,
            certification_img: null,
            certific_logo_img: null,
            certific_logo_img_url: null,
            evaluation_logo_img: null,
            evaluation_logo_img_url: null,
            extra_logo_img: null,
            extra_logo_img_url: null,
            initial_price: null,
            extra_price: null,
        },
        languages: [],
        locale: 'en',
        testType: null,
        exceptField: ['category_id', 'question_cnt', 'result_cnt'],
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
    langLoading: state => state.langLoading,
    testType: state => state.testType
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            //dispatch('ImageFileInput/getImage', null, { root: true }).then(result => {
            //    console.log(result);
            //    commit('setBackgroundImage', result);
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



            axios.post('/api/v1/tests', params)
                .then(response => {
                    //commit('resetState')
                    console.log(response);
                    commit('setItemId', response.data.data.id);
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
            //    commit('setBackgroundImage', result);
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
                    commit('setItem', response.data.data)
                        //dispatch('ImageFileInput/setImageUrl', state.item.certification_img_url, { root: true })
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch(
                            'Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })
                        //dispatch('ImageFileInput/setImageUrl', state.item.certification_img_url, { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
                //});
        })
    },
    fetchData({ commit, state, dispatch }, id) {
        commit('setDataLoading', true)
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/tests/' + id + '?locale=' + state.locale)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve();
                    //dispatch('ImageFileInput/setImageUrl', response.data.data.certification_img_url, { root: true });
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    dispatch('Alert/setAlert', { message: message, errors: errors, color: 'danger' }, { root: true })
                        //dispatch('ImageFileInput/setImageUrl', state.item.certification_img_url, { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setDataLoading', false)
                })
        });
        //commit('setItem', initialState().item);

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
    fetchTestType({ commit }, id) {
        commit('setLoading', true)
        axios.get('/api/v1/category/type/' + id)
            .then(response => {
                commit('setTestType', response.data.data)
            })
            .finally(() => {
                commit('setLoading', false);
            })
    },

    setCategoryId({ commit }, value) {
        commit('setCategoryId', value);
    },
    setTitle({ commit }, value) {
        commit('setTitle', value)
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
    },
    setTime({ commit }, value) {
        commit('setTime', value)
    },
    setInstruction({ commit }, value) {
        commit('setInstruction', value)
    },
    setQuestionCnt({ commit }, value) {
        commit('setQuestionCnt', value);
    },
    setResultCnt({ commit }, value) {
        commit('setResultCnt', value);
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

    setCreatedAt({ commit }, value) {
        commit('setCreatedAt', value);
    },
    setUpdatedAt({ commit }, value) {
        commit('setUpdatedAt', value);
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
    setCertificationFile({ commit, state }, value) {
        commit('setCertificationFile', value)
    },
    setExtraFile({ commit, state }, value) {
        commit('setExtraFile', value)
    },
    clearImage({ commit }) {
        commit('clearImage')
    },
    setCertificBackImage({ commit }, value) {
        commit('setCertificBackImage', value);
    },
    setInitialPrice({ commit }, value) {
        commit('setInitialPrice', value);
    },
    setExtraPrice({ commit }, value) {
        commit('setExtraPrice', value);
    },
    setCertificLogoImg({ commit }, value) {
        commit('setCertificLogoImg', value);
    },
    setEvaluationLogoImg({ commit }, value) {
        commit('setEvaluationLogoImg', value);
    },
    setExtraLogoImg({ commit }, value) {
        commit('setExtraLogoImg', value);
    }


}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setCategoryId(state, value) {
        state.item.category_id = Number(value);
    },
    setTitle(state, value) {
        state.item.title = value
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
    setDescription(state, value) {
        state.item.description = value
    },
    setTime(state, value) {
        state.item.time = value;
    },
    setInstruction(state, value) {
        state.item.instruction = value;
    },
    setQuestionCnt(state, value) {
        state.item.question_cnt = value;
    },
    setResultCnt(state, value) {
        state.item.result_cnt = value;
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
    setCertificationFile(state, value) {
        state.item.certification_file = value;
        if (value == null) {
            state.item.certification_file_url = null;
        } else {
            state.item.certification_file_url = value.name;
        }
    },
    setExtraFile(state, value) {
        state.item.extra_file = value;
        if (value == null) {
            state.item.extra_file_url = null;
        } else {
            state.item.extra_file_url = value.name;
        }
    },

    clearImage(state) {
        state.item.certification_img = null;
        state.item.certification_img_url = null;
    },
    setCertificBackImage(state, value) {
        state.item.certification_img = value;
    },
    setCertificLogoImg(state, value) {
        state.item.certific_logo_img = value;
    },
    setEvaluationLogoImg(state, value) {
        state.item.evaluation_logo_img = value
    },
    setExtraLogoImg(state, value) {
        state.item.extra_logo_img = value
    },

    setTestType(state, value) {
        state.testType = value;
    },
    setExtraPrice(state, value) {
        state.item.extra_price = value;
    },
    setInitialPrice(state, value) {
        state.item.initial_price = value;
    }

}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}