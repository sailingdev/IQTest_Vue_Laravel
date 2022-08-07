<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Answer</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form @submit.prevent="submitForm">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Create</h3>
              </div>

              <div class="box-body">
                <!-- <back-buttton></back-buttton> -->
                <router-link
                  v-if="$can('answer_access')"
                  :to="{ name: 'answers.index', params: { id: item.question_id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Answers
                </router-link>
              </div>

              <bootstrap-alert/>

              <div class="box-body">
                <div class="form-group">
                  <label for="title">Answer Text</label>
                  <textarea
                    rows="3"
                    class="form-control"
                    name="txt"
                    placeholder="Enter Answer *"
                    :value="item.txt"
                    @input="updateAnswerText"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label for="description">Answer Image</label>
                  <image-file-input ref="imgView" v-bind:image.sync="image" :initial="null"></image-file-input>
                </div>
                <!-- <div class="form-group">
                  <label for="description">Score</label>
                  <input
                    type="number"
                    class="form-control"
                    name="score"
                    placeholder="Enter Score(weight) *"
                    :value="item.score"
                    @input="updateAnswerScore"
                    required
                  >
                </div>-->
                <div class="form-group">
                  <label for="title">Result Text</label>
                  <input
                    type="text"
                    class="form-control"
                    name="txt"
                    placeholder="Enter Result Text *"
                    :value="item.result_text"
                    @input="updateResultText"
                  >
                </div>
              </div>

              <div class="box-footer">
                <vue-button-spinner
                  class="btn btn-primary btn-sm"
                  :isLoading="loading"
                  :disabled="loading"
                >Save</vue-button-spinner>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      // Code...
      image: null
    };
  },
  created() {
    // Code ...
    this.init();
  },
  computed: {
    ...mapGetters("AnswersSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {}
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("AnswersSingle", [
      "storeData",
      "resetState",
      "setAnswerText",
      "setResultText",
      "setAnswerImage",
      "setAnswerScore",
      "setQuestionId",
      "setImage"
    ]),
    init() {
      this.image = null;
      this.resetState();
      this.setQuestionId(this.$route.params.id);
    },
    updateAnswerText(e) {
      this.setAnswerText(e.target.value);
    },
    updateAnswerScore(e) {
      this.setAnswerScore(e.target.value);
    },
    updateResultText(e) {
      this.setResultText(e.target.value);
    },
    submitForm() {
      this.setImage(this.image);
      this.storeData()
        .then(() => {
          this.$router.push({
            name: "answers.index"
          });
          this.$eventHub.$emit("create-success");
          this.$refs.imgView.resetImage();
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>

<style scoped>
</style>
