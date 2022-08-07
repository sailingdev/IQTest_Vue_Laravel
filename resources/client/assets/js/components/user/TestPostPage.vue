<template>
  <div class="main-content main-content-test">
    <div class="main-content__container">
      <div class="post-test">
        <h3>{{test.post_page_title}}</h3>
        <p>{{test.post_page_desc}}</p>
        <div
          class="lopende-tekst vraag"
          v-for="(postQuestion, index) in postQuestions"
          v-bind:key="postQuestion.id"
          v-bind:class="index%2==0?'rij-even':'rij-odd'"
        >
          <h4>
            <span>{{index + 1}} .</span>
          </h4>
          <div class="subvraag">
            <h3>{{postQuestion.txt}}</h3>
            <br>
            <div>
              <div v-for="answer in postQuestion.answers" v-bind:key="answer.id">
                <input
                  style="display:none"
                  type="radio"
                  :id="answer.id"
                  :value="answer.txt"
                  v-model="userAnswers[index]"
                >
                <label :for="answer.id">{{answer.txt}}</label>
                <br>
                <br>
              </div>
            </div>
          </div>
        </div>
        <div class="einde-test-knop-container">
          <button
            type="button"
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
      testId: this.$route.params.id,
      nextFlag: false
    };
  },
  computed: {
    ...mapGetters("TestData", [
      "test",
      "postQuestions",
      "preQuestions",
      "mainQuestions"
    ])
  },
  watch: {
    userAnswers: {
      handler: function() {
        if (this.userAnswers.length != this.postQuestions.length) {
          return;
        }

        for (var i in this.postQuestions) {
          if (this.userAnswers[i] != this.postQuestions[i].user_answer) {
            console.log("changed!" + this.userAnswers[i]);
            this.setPostAnswer({
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
  // beforeRouteLeave(to, from, next) {
  //   this.resetState();
  //   next();
  // },
  created() {
    var id = this.$route.params.id;
    if (this.test.id != id) {
      this.$router.push({
        name: "user.test.load",
        params: { id: id }
      });
    } else {
      if (this.postQuestions.length == 0) {
        this.goToNext();
      } else {
        for (var i in this.postQuestions) {
          this.userAnswers.push(this.postQuestions[i].user_answer);
        }
      }
    }
  },
  methods: {
    ...mapActions("TestData", ["setPostAnswer", "resetState"]),
    goToNext() {
      //this.setpostAnswers(this.userAnswers);
      this.nextFlag = true;
      var answers = "";
      for (var i in this.preQuestions) {
        answers += this.preQuestions[i].user_answer + " ";
      }
      for (var i in this.postQuestions) {
        answers += this.postQuestions[i].user_answer + " ";
      }
      for (var i in this.mainQuestions) {
        answers += this.mainQuestions[i].user_answer + " ";
      }
      //alert(answers);
      //this.resetState();
      this.$router.push({
        name: "user.test.finish",
        params: { id: this.$route.params.id }
      });
    }
  }
};
</script>
<style scope>
div.rij-odd {
  background-color: white;
  margin-bottom: 10px;
  padding: 10px;
}
div.rij-even {
  background-color: rgb(240, 240, 240);
  margin-bottom: 10px;
  padding: 10px;
}
/* label {
  display: initial;
} */
.post-test {
  padding-top: 20px;
  margin-left: 15%;
  margin-right: 15%;
}
/* .radio{
  padding-top:15px;
} */
</style>

