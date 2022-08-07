<template>
  <div class="main-content main-content-test">
    <div class="main-content__container">
      <div class="pre-test">
        <h3>{{test.pre_page_title}}</h3>
        <p>{{test.pre_page_desc}}</p>
        <div
          class="lopende-tekst vraag"
          v-for="(preQuestion, index) in preQuestions"
          v-bind:key="preQuestion.id"
          v-bind:class="index%2==0?'rij-even':'rij-odd'"
        >
          <h4>
            <span>{{index + 1}} .</span>
          </h4>

          <div class="subvraag">
            <div style="margin:auto"></div>

            <h4>{{preQuestion.txt}}</h4>
            <br>
            <div class="row">
              <div v-for="answer in preQuestion.answers" v-bind:key="answer.id">
                <input
                  style="display:none"
                  type="radio"
                  :id="answer.id"
                  :value="answer.txt"
                  v-model="userAnswers[index]"
                >
                <label :for="answer.id">
                  <!-- <br> -->
                  <span>{{answer.txt}}</span>
                </label>
                <br>
                <br>
              </div>
            </div>
          </div>
        </div>
        <div class>
          <button
            type="button"
            style="float:right"
            class="btn btn-primary einde-test-knop its123-btn-loading"
            @click="goToNext"
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
      testId: this.$route.params.id
    };
  },
  computed: {
    ...mapGetters("TestData", ["test", "preQuestions", "mainQuestions"])
  },
  watch: {
    userAnswers: {
      handler: function() {
        if (this.userAnswers.length != this.preQuestions.length) {
          return;
        }

        for (var i in this.preQuestions) {
          if (this.userAnswers[i] != this.preQuestions[i].user_answer) {
            console.log("changed!" + this.userAnswers[i]);
            this.setPreAnswer({
              index: i,
              value: this.userAnswers[i]
            });
          }
        }
      },
      deep: true,
      immediate: true
    }
  },
  beforeRouteLeave(to, from, next) {
    console.log(to);
    if (to.name == "user.test.load" && from.name == "user.test.pre") {
      next(false);
      // var answer = window.confirm("Do you want to leave the test?");
      // if (answer) {
      //   this.resetState();
      //   next({ name: "user.test.detail" });
      // } else {
      //   next(false);
      // }
    } else {
      next();
    }
  },
  created() {
    document.addEventListener("backbutton", this.backPressed, false);
    var id = this.$route.params.id;
    if (this.test.id == null) {
      this.$router.push({
        name: "user.test.detail",
        params: { id: this.$route.params.id }
      });
      return;
    }
    if (this.test.id != id) {
      this.$router.push({
        name: "user.test.load",
        params: { id: id }
      });
    } else {
      for (var i in this.preQuestions) {
        this.userAnswers.push(this.preQuestions[i].user_answer);
      }
    }
  },
  methods: {
    ...mapActions("TestData", ["setPreAnswer", "resetState"]),
    goToNext() {
      //this.setPreAnswers(this.userAnswers);
      if (this.mainQuestions.length > 0) {
        this.$router.push({
          name: "user.test.main",
          params: { id: this.$route.params.id }
        });
      } else {
        this.$router.push({
          name: "user.test.post",
          params: { id: this.$route.params.id }
        });
      }
    },
    backPressed() {}
  }
};
</script>
<style scope>
div.rij-odd {
  background-color: white;
  margin-bottom: 10px;
  padding: 20px;
}
div.rij-even {
  background-color: rgb(240, 240, 240);
  margin-bottom: 10px;
  padding: 20px;
}
/* label {
  display: initial;
} */
.pre-test {
  padding: 20px, 0px, 20px, 0px;
  margin-left: 15%;
  margin-right: 15%;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
/* .radio{
  padding-top:15px;
} */
</style>

