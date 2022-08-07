<template>
  <div class="main-content main-content-test">
    <div class="main-content__container">
      <div class="test-problem">
        <div class="well well-sm" style="text-align:center">
          <h2 style="color: #dd3b2a;">
            <!-- <i class="fa fa-question-circle-o"></i> -->
            {{test.title}}
          </h2>
        </div>
        <!-- <div class="progress">
          <span v-for="index in mainQuestions.length" :key="index" style="position:relative">
            <span
              v-if="index>1"
              class="bar"
              v-bind:class="[index-1 < no ? 'done' : (index-1 == no ? 'half' : '') ]"
            ></span>
            <div
              class="circle"
              v-bind:class="[index-1 < no ? 'done' : (index-1 == no ? 'active' : '') ]"
              @click="goToCustomProblem(index-1)"
            >
              <span class="label">{{index}}</span>
            </div>
          </span>
        </div>-->

        <div class="lopende-tekst vraag rij-even">
          <h4>
            <span>{{no + 1}} / {{mainQuestions.length}}</span>
          </h4>
          <div class="subvraag">
            <div style="margin:auto"></div>
            <img
              :src="mainQuestions[no].img_url"
              class="question_img center"
              v-if="mainQuestions[no].img_url"
            >
            <h4>{{mainQuestions[no].txt}}</h4>
            <br>
            <div class="row" v-if="mainQuestions[no].question_type == 1">
              <div class="fancy-checkbox-holder">
                <div
                  class="fancy-radio with-icon"
                  v-for="(answer,index) in mainQuestions[no].answers"
                  v-bind:key="answer.id"
                  v-bind:class="[isActive[index] ? 'active' : '']"
                  @click="onAnswerClick(index)"
                >
                  <div class="icon">
                    <div
                      class="icon-img"
                      :style="'-webkit-mask-box-image: url(' + answer.img_url + ');'"
                    ></div>
                  </div>
                  <div class="icon"></div>
                  {{answer.txt}}
                  <div class="status"></div>
                  <div class="status-icon">{{ isActive[index] ? '+' : '-'}}</div>
                </div>
              </div>
            </div>
            <div class="row" v-if="mainQuestions[no].question_type == 0">
              <div
                v-for="answer in mainQuestions[no].answers"
                v-bind:key="answer.id"
                class="c-radio__item"
              >
                <input
                  style="display:none"
                  type="radio"
                  class="c-radio__input"
                  :id="answer.id"
                  :value="answer.id"
                  v-model="userAnswers[no]"
                  @click="goToNext(answer.id)"
                >
                <label :for="answer.id" class="c-radio__answer">
                  <img :src="answer.img_url" class="answer_img" v-if="answer.img_url">
                  <br v-if="answer.img_url">
                  <span v-if="answer.img_url" style="padding-left:25px">{{answer.txt}}</span>
                  <span v-if="!answer.img_url" class="c-radio__text">{{answer.txt}}</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div v-show="mainQuestions[no].question_type == 1">
          <button
            type="button"
            style="float:right;font-size:30px;margin-bottom:50px"
            class="btn btn-secondary einde-test-knop its123-btn-loading"
            @click="goToNext(null)"
          >{{ trans('userpage.txt_next_btn') }}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      userAnswers: [],
      isActive: [],
      testId: this.$route.params.id
    };
  },
  computed: {
    ...mapGetters("TestData", [
      "test",
      "no",
      "mainQuestions",
      "testRunning",
      "testEndFlag"
    ])
  },
  watch: {
    userAnswers: {
      handler: function() {
        // if (this.userAnswers.length != this.preQuestions.length) {
        //   return;
        // }
        // for (var i in this.preQuestions) {
        //   if (this.userAnswers[i] != this.preQuestions[i].user_answer) {
        //     console.log("changed!" + this.userAnswers[i]);
        //     this.setPreAnswer({
        //       index: i,
        //       value: this.userAnswers[i]
        //     });
        //   }
        // }
      },
      deep: true,
      immediate: true
    },
    no: {
      handler: function() {
        this.isActive = [];
        for (var j in this.mainQuestions[this.no].answers) {
          this.isActive.push(false);
        }
      },
      deep: true,
      immediate: true
    }
  },
  beforeRouteLeave(to, from, next) {
    if (to.name == "user.test.pre" && from.name == "user.test.main") {
      next(false);
    } else {
      next();
    }
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
          //this.increaseNo();
        }

        for (var i in this.mainQuestions) {
          this.userAnswers.push(this.mainQuestions[i].user_answer);
        }
        for (var j in this.mainQuestions[this.no].answers) {
          this.isActive.push(false);
        }
      }
    }
  },
  destroyed() {
    if (!this.testEndFlag) {
      this.resetState();
    }
  },
  methods: {
    ...mapActions("TestData", [
      "resetState",
      "setMainAnswer",
      "setTestRunningFlag",
      "setTestEndFlag",
      "increaseNo",
      "setNo"
    ]),
    onAnswerClick(index) {
      if (this.isActive[index]) {
        Vue.set(this.isActive, index, false);
      } else {
        Vue.set(this.isActive, index, true);
      }
    },
    goToCustomProblem(problemNo) {
      this.setNo(problemNo);
    },
    goToNext(answerId) {
      if (this.testEndFlag) {
        return;
      }
      this.setMainAnswer({
        index: this.no,
        //value: this.userAnswers[this.no]
        value: answerId
      });
      if (this.no == this.mainQuestions.length - 1) {
        this.setTestEndFlag(true);
        this.$router.push({
          name: "user.test.post",
          params: { id: this.$route.params.id }
        });
      } else {
        var parent = this;
        setTimeout(function() {
          parent.increaseNo();
        }, 300);
      }
    }
  }
};
</script>
<style scope>
@import "../../../css/customize.css";

div.rij-odd {
  background-color: white;
  margin-bottom: 10px;
  padding: 20px;
}
div.rij-even {
  /* background-color: #109df6c0; */
  /* color: white; */
  color: black;
  margin-bottom: 10px;
  padding: 40px;
  border-radius: 15px 130px 30px 120px;
  box-shadow: 0 14px 18px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
/* label {
  display: initial;
} */
.test-problem {
  padding: 50px, 0px, 50px, 0px;
  margin-left: 15%;
  margin-right: 15%;
  margin-top: 20px;
  margin-bottom: 20px;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
.question_img {
  /* min-height: 300px; */
  max-height: 350px;
  object-fit: contain;
  width: auto;
  /* border-style: ridge !important; */
  padding: 10px;
  /* border: #f0f0f0; */
}
.answer_img {
  height: 150px;
  width: 200px;
}
.answer-part {
  padding-left: 15px;
}

/* .radio{
  padding-top:15px;
} */
.img {
  width: 50px;
  height: 50px;
  mask: url(#mymask);
  -webkit-mask-box-image: url(/uploads/chicken.png);
}
.fancy-checkbox-holder {
  width: 70%;
  margin: auto;
}
</style>


