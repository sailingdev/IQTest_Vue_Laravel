function initialState() {
    return {
        item: {
            id: null,
            name: null,
            //value: null,
            description: null,
            //created_at: null,
            //updated_at: null,
        },

        defaultImgUrl: null,
        exceptField: ['created_at', 'updated_at'],
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
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


            axios.post('/api/v1/topics', params)
                .then(response => {
                    commit('resetState')
                    console.log(response);
                    //commit('setItem', response.data.data);
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


            axios.post('/api/v1/topics/' + state.item.id, params)
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
    fetchData({ commit, dispatch }, id) {
        commit('setLoading', true)
        axios.get('/api/v1/topics/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    setName({ commit }, value) {
        commit('setName', value);
    },
    setValue({ commit }, value) {
        commit('setValue', value);
    },
    setDescription({ commit }, value) {
        commit('setDescription', value)
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

}

const mutations = {
    setItem(state, item) {
        state.item = item;
    },
    setName(state, value) {
        state.item.name = value;
    },
    setValue(state, value) {
        state.item.value = value;
    },
    setDescription(state, value) {
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