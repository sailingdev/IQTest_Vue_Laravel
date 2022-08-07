function initialState() {
    return {
        test: {
            test_type: null,
            id: null,
            title: null,
            pre_page_title: null,
            pre_page_desc: null,
            post_page_title: null,
            post_page_desc: null,
            time: null,
            questions: null,
        },
        base64Imgs: {},
        preQuestions: [],
        postQuestions: [],
        mainQuestions: [],
        statusMessage: null,
        totalImgCnt: 0,
        locale: 'en',
        loading: true,

        //main test variables
        no: 0,
        counter: 0,
        testRunning: false,
        testEndFlag: false

    }
}

const getters = {
    test: state => state.test,
    loading: state => state.loading,

    locale: state => state.locale,
    statusMessage: state => state.statusMessage,
    preQuestions: state => state.preQuestions,
    postQuestions: state => state.postQuestions,
    mainQuestions: state => state.mainQuestions,
    no: state => state.no,
    counter: state => state.counter,
    testRunning: state => state.testRunning,
    testEndFlag: state => state.testEndFlag
}

const actions = {
    upload({ commit, state }, extraInfo) {
        var results = [];
        for (var i in state.mainQuestions) {
            results.push({
                questionId: state.mainQuestions[i].id,
                answerId: state.mainQuestions[i].user_answer
            })
        }
        var topics = [];
        for (var i in state.preQuestions) {
            topics.push({
                topic: state.preQuestions[i].topic_name,
                answer: state.preQuestions[i].user_answer
            })
        }
        for (var i in state.postQuestions) {
            topics.push({
                topic: state.postQuestions[i].topic_name,
                answer: state.postQuestions[i].user_answer
            })
        }
        for (var i in state.mainQuestions) {
            if (state.mainQuestions[i].topic_name != 'Normal') {
                //find answer
                var answer = null;
                for (var j in state.mainQuestions[i].answers) {
                    if (state.mainQuestions[i].answers[j].id ==
                        state.mainQuestions[i].user_answer) {
                        answer = state.mainQuestions[i].answers[j].txt;
                        break;
                    }
                }
                if (answer != null) {
                    topics.push({
                        topic: state.mainQuestions[i].topic_name,
                        answer: answer
                    })
                }
            }
        }
        console.log(results);
        console.log(topics);
        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('test_id', state.test.id);
            params.set('time', state.test.time * 60 - state.counter);
            console.log(state.test.time * 60 - state.counter);
            params.set('result', JSON.stringify(results));
            params.set('topic_key', JSON.stringify(topics));
            params.set('mobile_number', extraInfo.mobileNumber);
            params.set('user_name', extraInfo.userName);
            params.set('user_ip', extraInfo.userIP);
            params.set('country', extraInfo.country);

            console.log(params);
            commit('setLoading', true)
            axios.post('/api/v2/uploadResult', params)
                .then(response => {
                    //commit('resetState')
                    console.log(response);
                    resolve(response.data.data.token);
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
    fetchData({ commit, state, dispatch }, id) {
        commit('resetState')
        commit('setStatusMessage', window.i18n.userpage.txt_loading_data)
        axios.get('/api/v2/tests/data/' + id + '?locale=' + state.locale)
            .then(response => {


                var value = response.data.data;
                var imgCnt = 0;
                var imgUrls = [];

                for (var i in value.questions) {
                    var qImg = value.questions[i].img_url;

                    if (qImg != null) {
                        imgCnt++;
                        imgUrls.push(qImg);
                        //dispatch('fetchImage', index, qImg);
                    }
                    for (var j in value.questions[i].answers) {
                        var aImg = value.questions[i].answers[j].img_url;
                        if (aImg != null) {
                            imgCnt++;
                            imgUrls.push(aImg);
                            //dispatch('fetchImage', index, aImg);
                        }
                    }
                }

                commit('setTestData', value)
                    //commit('setStatusMessage', "Loading Images...")
                commit('setStatusMessage', window.i18n.userpage.txt_loading_img);
                commit('setTotalImgCnt', imgCnt);

                for (var i in imgUrls) {
                    dispatch('fetchImage', { index: i, url: imgUrls[i] });
                }
                if (imgUrls.length == 0) {
                    commit('setData');
                }
            })
            .catch(error => {
                commit('setLoading', false)
            })
            .finally(() => {
                //commit('setLoading', false)
            })
    },
    fromBlobToBase64({ commit, state }, blob) {
        return new Promise((resolve, reject) => {
            let reader = new FileReader()
            reader.addEventListener('loadend', event => {
                resolve(reader.result)
            })
            reader.readAsDataURL(blob)
        })
    },
    fetchImage({ commit, state, dispatch }, value) {
        commit('setLoading', true)
        var xhr = new XMLHttpRequest();
        xhr.open("GET", value.url, true);
        xhr.responseType = "blob";
        xhr.onload = function(e) {
            dispatch('fromBlobToBase64', this.response).then(result => {
                //console.log(value.index + '===========' + result);
                commit('setImg', { index: value.index, image: result });
                //commit('pushImg', result);
            });
        };
        xhr.send();
    },

    setTestId({ commit }, value) {
        commit('setTestId', value);
    },
    resetState({ commit }) {
        commit('resetState')
    },
    setLoading({ commit }, value) {
        commit('setLoading', value);
    },
    setStatusMessage({ commit }, value) {
        commit('setStatusMessage', value);
    },
    setLocale({ commit, state }, value) {
        commit('setLocale', value)
    },
    setPreAnswer({ commit }, value) {
        commit('setPreAnswer', value);
    },
    setPostAnswer({ commit }, value) {
        commit('setPostAnswer', value);
    },
    setMainAnswer({ commit }, value) {
        commit('setMainAnswer', value);
    },
    setTestRunningFlag({ commit }, value) {
        commit('setTestRunningFlag', value);
    },
    increaseNo({ commit }) {
        commit('increaseNo');
    },
    pushImg({ commit }, img) {
        commit('pushImg', img);
    },
    decreaseCounter({ commit }) {
        commit('decreaseCounter');
    },
    setTestEndFlag({ commit }, value) {
        commit('setTestEndFlag', value);
    },
    setNo({ commit }, value) {
        commit('setNo', value);
    }



}

const mutations = {
    setTestId(state, value) {
        state.test.id = value;
    },
    pushImg(state, img) {
        //state.base64Imgs.push(img);
    },
    increaseNo(state) {
        if (state.no == state.mainQuestions.length - 1) {
            alert("Test is finished!");
            state.testRunning = false;
            state.testEndFlag = true;
        }
        if (state.testRunning) {
            state.no = state.no + 1;
        }

    },
    setNo(state, value) {
        state.no = value;
    },
    decreaseCounter(state) {
        if (state.testRunning && state.counter == 0) {
            alert("Test is finished!");
            state.testRunning = false;
            state.testEndFlag = true;
        }
        if (state.testRunning) {
            state.counter--;
        }
    },
    setTestData(state, value) {
        state.test = value;

        //state.test.questions = null;
    },
    setTestRunningFlag(state, value) {
        state.testRunning = value;
        if (value) {
            state.no = 0;
            state.counter = state.test.time * 60; //calculate as second!
            for (var i in state.mainQuestions) {
                state.mainQuestions[i].user_answer = null;
            }
        }
    },
    setPreAnswer(state, value) {
        console.log(value.index + ' ' + value.value);
        state.preQuestions[value.index].user_answer = value.value;
    },
    setPostAnswer(state, value) {
        console.log(value.index + ' ' + value.value);
        state.postQuestions[value.index].user_answer = value.value;
    },

    setMainAnswer(state, value) {
        state.mainQuestions[value.index].user_answer = value.value;
    },

    setStatusMessage(state, value) {
        state.statusMessage = value;
    },
    setTotalImgCnt(state, value) {
        state.totalImgCnt = value;
        if (state.totalImgCnt == 0) {
            state.loading = false;
            state.statusMessage = 'Done!';
        }
    },
    setData(state) {
        var value = state.test;
        console.log(value);
        var imgIndex = 0;
        for (var i in value.questions) {
            var qImg = value.questions[i].img_url;

            if (qImg != null) {
                value.questions[i].img_url = state.base64Imgs[imgIndex++];
            }
            for (var j in value.questions[i].answers) {
                var aImg = value.questions[i].answers[j].img_url;
                if (aImg != null) {
                    value.questions[i].answers[j].img_url = state.base64Imgs[imgIndex++];
                }
            }
        }

        for (var i in value.questions) {
            switch (value.questions[i].page) {
                case 'pre':
                    state.preQuestions.push(value.questions[i]);
                    break;
                case 'post':
                    state.postQuestions.push(value.questions[i]);
                    break;
                default:
                    state.mainQuestions.push(value.questions[i]);
                    break;
            }
        }
        console.log(state.test);
        state.test.questions = null;
        state.base64Imgs = [];

        state.loading = false;
    },
    setImg(state, result) {
        state.totalImgCnt--;
        state.base64Imgs[result.index] = result.image;

        if (state.totalImgCnt == 0) {
            var value = state.test;
            console.log(value);
            var imgIndex = 0;
            for (var i in value.questions) {
                var qImg = value.questions[i].img_url;

                if (qImg != null) {
                    value.questions[i].img_url = state.base64Imgs[imgIndex++];
                }
                for (var j in value.questions[i].answers) {
                    var aImg = value.questions[i].answers[j].img_url;
                    if (aImg != null) {
                        value.questions[i].answers[j].img_url = state.base64Imgs[imgIndex++];
                    }
                }
            }

            for (var i in value.questions) {
                switch (value.questions[i].page) {
                    case 'pre':
                        state.preQuestions.push(value.questions[i]);
                        break;
                    case 'post':
                        state.postQuestions.push(value.questions[i]);
                        break;
                    default:
                        state.mainQuestions.push(value.questions[i]);
                        break;
                }
            }
            console.log(state.test);
            state.test.questions = null;
            state.base64Imgs = [];

            state.loading = false;
            //state.statusMessage = 'Done!';
        }
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    resetMainQuestionAnswers(state) {
        for (var i in state.mainQuestions) {
            state.mainQuestions[i].user_answer = null;
        }
    },
    setLocale(state, value) {
        state.locale = value;
    },
    setTestEndFlag(state, value) {
        state.testEndFlag = value;
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}