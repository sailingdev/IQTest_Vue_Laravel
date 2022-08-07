function initialState() {
    return {
        item: {
            id: null,
            token: null,
            title: null,
            eval_logo_img: null,
            cert_logo_img: null,
            extra_logo_img: null,
            time: null,
            initial_price: null,
            extra_price: null
        },
        extra_pay: false,
        amount: 0,
        loading: false,
        orderStatus: false

    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    amount: state => state.amount,
    orderStatus: state => state.orderStatus,
    extra_pay: state => state.extra_pay
}

const actions = {
    fetchData({ commit, state }, token) {
        commit('resetState')
        commit('setLoading', true)
        axios.get('/api/v2/order/' + token)
            .then(response => {
                console.log(response.data.data);
                commit('setItem', response.data.data)
            })
            .catch(error => {

            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    stripeOrder({ commit, state }, stripeToken) {
        commit('setLoading', true)
        commit('setOrderStatus', true)
        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('token', state.item.token)
            params.set('stripeToken', JSON.stringify(stripeToken))
            params.set('extra_pay', state.extra_pay ? 1 : 0)

            axios.post('/api/v2/order/stripe/post', params)
                .then(response => {
                    console.log(response)

                    resolve(response)
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors = error.response.data.errors

                    reject(message)
                })
                .finally(() => {
                    commit('setLoading', false)
                    commit('setOrderStatus', false)
                })
        })

    },
    setAmount({ commit }, value) {
        commit('setAmount', value);
    },
    setExtraPay({ commit }, value) {
        commit('setExtraPay', value);
    },
    setTestToken({ commit }, value) {
        commit('setTestToken', value);
    }

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
        state.amount = value.initial_price;
    },
    setAmount(state, value) {
        state.amount = value;
    },
    setOrderStatus(state, value) {
        state.orderStatus = value
    },
    setExtraPay(state, value) {
        state.extra_pay = value;
    },
    setTestToken(state, value) {
        state.item.token = value;
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}