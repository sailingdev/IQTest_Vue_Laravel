<template>
  <div class="main-content main-content-test">
    <div class="main-content__container">
      <div class="test__header">
        <div class="row">
          <div class="col-xxs-12 col-md-7 col-lg-8">
            <div
              class="test__title"
            >Choose one of the variants to replace the missing shape {{mainQuestions[no].txt}}</div>
          </div>
          <div class="col-xxs-12 col-md-5 col-lg-4">
            <div class="row test__progress-row">
              <div
                class="col-xxs-6 col-sm-3 col-sm-offset-3 col-md-6 col-md-offset-0 col-lg-offset-2 test__progress-container"
              >
                <div class="test__progress">{{no + 1}} / {{mainQuestions.length}}</div>
                <div class="test__actions">
                  <div
                    class="btn btn-secondary--flat test__skip-btn link-test-answer"
                    @click="answerClicked(null)"
                  >{{ trans('userpage.txt_skip_btn') }}</div>
                </div>
              </div>
              <div class="col-xxs-6 col-md-5 col-lg-4 test__timer-container">
                <div class="test__timer">
                  <div
                    class="timer js-countdown test__timer-box"
                    data-end-date="Thu May 16 2019 02:49:01 GMT+0800 (China Standard Time)"
                    data-minutes-format="%M"
                    data-seconds-format="%S"
                  >{{counter | timeFormatHMS}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="test__container">
        <div class="test__task row">
          <div class="col-md-7 col-lg-offset-2 col-lg-6">
            <div class="test__question">
              <img :src="mainQuestions[no].img_url" class="test__question-svg">
            </div>
          </div>
          <div class="col-md-5 col-lg-4">
            <div class="test__answer">
              <div class="options">
                <div
                  class="options__item link-test-answer"
                  v-for="answer in mainQuestions[no].answers"
                  v-bind:key="answer.id"
                >
                  <div class="options__content">
                    <img
                      v-if="answer.img_url"
                      class="options__content-svg"
                      :src="answer.img_url"
                      @click="answerClicked(answer.id)"
                    >
                  </div>
                  <!-- <span>{{index + 1}}</span> -->

                  <div v-if="answer.txt" class="txtPart" @click="answerClicked(answer.id)">
                    <span>{{answer.txt}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import counter from "./Counter.vue";

export default {
  data() {
    return {
      userAnswers: [],
      testId: this.$route.params.id,
      timer: null
    };
  },
  components: {
    //   counter
  },
  computed: {
    ...mapGetters("TestData", [
      "test",
      "mainQuestions",
      "no",
      "testRunning",
      "testEndFlag",
      "counter"
    ])
  },

  created() {
    var id = this.$route.params.id;
    if (this.test.id == null || this.test.id != id) {
      //|| this.testStarted) {
      this.$router.push({
        name: "user.test.load",
        params: { id: this.$route.params.id }
      });
    } else {
      if (this.testEndFlag) {
        alert("Test is already finished!");
        this.$router.push({
          name: "user.test.post",
          params: { id: this.$route.params.id }
        });
      } else {
        if (!this.testRunning) {
          this.setTestRunningFlag(true);
        } else {
          this.increaseNo();
        }
        setTimeout(this.createTimer, 500);

        for (var i in this.mainQuestions) {
          this.userAnswers.push(this.mainQuestions[i].user_answer);
        }
      }
    }
  },
  //   beforeRouteEnter(to, from, next) {
  //       console.log(from);

  //     if (from.name == "user.test.pre" || from.name == 'user.test.main') {
  //       next();
  //     } else {
  //       next(false);
  //     }
  //   },
  beforeRouteLeave(to, from, next) {
    if (to.name == "user.test.pre" && from.name == "user.test.main") {
      next(false);
    } else {
      next();
    }
  },

  destroyed() {
    if (this.timer != null) {
      clearInterval(this.timer);
    }
    if (!this.testEndFlag) {
      this.resetState();
    } else {
      //save counter to window varaible
      //window.laravel.completeTime = this.counter;
      //*******************************
    }
  },
  methods: {
    ...mapActions("TestData", [
      "resetState",
      "setMainAnswer",
      "setTestRunningFlag",
      "setTestEndFlag",
      "increaseNo",
      "decreaseCounter"
    ]),
    answerClicked(answerId) {
      //alert(index);
      if (this.testEndFlag) {
        return;
      }
      this.setMainAnswer({
        index: this.no,
        value: answerId
      });
      if (this.no == this.mainQuestions.length - 1) {
        this.setTestEndFlag(true);
        this.$router.push({
          name: "user.test.post",
          params: { id: this.$route.params.id }
        });
      }
      this.increaseNo();
    },
    createTimer() {
      this.timer = setInterval(this.intervalFunc, 1000);
    },
    intervalFunc() {
      //console.log(this.counter);
      this.decreaseCounter();
    }
  }
};
</script>
<style scope>
/* .main-content__container{
  max-width: none;
  padding: 0px;
  margin: 0px;
} */
</style>