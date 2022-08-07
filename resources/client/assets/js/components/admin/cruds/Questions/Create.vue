<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Question</h1>
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
                  v-if="$can('question_access')"
                  :to="{ name: 'questions.index', params: { id: item.test_id, type:'all' }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Questions
                </router-link>
              </div>

              <bootstrap-alert/>
              <div class="row" v-if="loading">
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                  </div>
                </div>
              </div>
              <div class="box-body" v-if="!loading">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>Select Page Type:</label>
                    <select
                      class="form-control"
                      name="page"
                      required
                      :value="item.page"
                      @input="updatePageType"
                    >
                      <option value="normal">Normal Page</option>
                      <option value="pre">Pre Page</option>
                      <option value="post">Post Page</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="sel1">Select Key Topic:</label>
                    <select
                      class="form-control"
                      name="locale"
                      required
                      :value="item.topic_id"
                      @input="updateTopic"
                    >
                      <option value="0">Normal</option>
                      <option
                        v-for="topic in topics"
                        v-bind:key="topic.id"
                        :value="topic.id"
                      >{{topic.name}}</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>Select Question Type:</label>
                    <select
                      class="form-control"
                      name="questionType"
                      required
                      @input="updateQuestionType"
                    >
                      <option value="0">Single Choice</option>
                      <option value="1">Multiple Choice</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="title">Question Text</label>
                  <textarea
                    rows="3"
                    class="form-control"
                    name="txt"
                    placeholder="Enter Question *"
                    :value="item.txt"
                    @input="updateQuestionText"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label for="description">Question Image</label>
                  <image-file-input ref="imgView" v-bind:image.sync="image" :initial="null"></image-file-input>
                </div>
                <div class="form-group">
                  <label for="description">Correct Answer Explanation</label>
                  <textarea
                    rows="3"
                    class="form-control"
                    name="correct_ans_exp"
                    placeholder="Enter Answer Explanation"
                    :value="item.correct_ans_exp"
                    @input="updateAnswerExplanation"
                  ></textarea>
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
      xprops: {
        module: "QuestionsCreate",
        route: "questions",
        storeModule: "QuestionsSingle",
        permission_prefix: "question_"
      },
      image: null,
      testId: this.$route.params.id,
      questionType:
        this.$route.params.type == "all" ? "normal" : this.$route.params.type
    };
  },
  created() {
    // Code ...
    this.init();
  },
  computed: {
    ...mapGetters("QuestionsSingle", ["item", "loading", "topics"])
  },
  watch: {
    "$route.params.id": function() {
      this.init();
    }
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("QuestionsSingle", [
      "storeData",
      "fetchKeyTopicData",
      "resetState",
      "setPageType",
      "setQuestionText",
      "setAnswerExplanation",
      "setTopic",
      "setTestId",
      "setQuestionType",
      "setImage"
    ]),
    init() {
      this.image = null;
      this.resetState();
      this.fetchKeyTopicData();
      this.setTestId(this.$route.params.id);
      this.setPageType(
        this.$route.params.type == "all" ? "normal" : this.$route.params.type
      );
    },
    updateTopic(e) {
      this.setTopic(e.target.value);
    },
    updatePageType(e) {
      this.setPageType(e.target.value);
    },
    updateQuestionText(e) {
      this.setQuestionText(e.target.value);
    },
    updateAnswerExplanation(e) {
      this.setAnswerExplanation(e.target.value);
    },
    updateQuestionType(e) {
      this.setQuestionType(e.target.value);
    },
    submitForm() {
      this.setImage(this.image);
      this.storeData()
        .then(result => {
          this.$router.push({
            name: "questions.index",
            params: { id: this.testId, type: "all" }
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
