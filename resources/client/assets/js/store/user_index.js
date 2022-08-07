import Vue from 'vue'
import Vuex from 'vuex'


import TestsIndex from './userModules/Tests'
import TestsSingle from './userModules/Tests/single'
import TestData from './userModules/Tests/fulldata'
import OrderData from './userModules/Tests/order'
import ResultExamData from './userModules/Tests/result_exam'
import ResultMultiData from './userModules/Tests/result_multi'

import createPersistedState from 'vuex-persistedstate'
import Cookies from 'js-cookie';


Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        TestsIndex,
        TestsSingle,
        TestData,
        OrderData,
        ResultExamData,
        ResultMultiData
    },
    plugins: [
        createPersistedState({
            paths: ['TestData', 'OrderData'],
        }),
    ],
    strict: debug,
})