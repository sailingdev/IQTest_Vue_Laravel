function initialState() {
    return {
        img: null
    }
}

const getters = {
    img: state => state.img
}

const actions = {
    setImage({ commit }, value) {
        let reader = new FileReader();
        reader.onload = (e) => {
            commit('setImage', e.target.result)
        };
        reader.readAsDataURL(value);
    },
    setImageUrl({ commit }, value) {
        commit('setImage', value)
    },
    getImage({ getters }) {
        return getters.img;
    },
    clearImage({ commit }) {
        commit('clearImage')
    },
    resetState({ commit }) {
        commit('resetState')
    },
    resetImage({ commit }) {
        commit('resetState')
    }
}

const mutations = {

    resetState(state) {
        console.log('reset image!');
        state = Object.assign(state, initialState())
    },
    setImage(state, value) {
        console.log('set image url!');
        state.img = value;
    },
    clearImage(state) {
        state.img = null;
    },
    getImage(state, value) {
        return state.img;
        //console.log(value);
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}