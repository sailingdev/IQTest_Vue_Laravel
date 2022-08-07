<template>
<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Key Topic Question</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form @submit.prevent="submitForm">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <bootstrap-alert />
                       
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="sel1">Select Language:</label>
                                    <select class="form-control" name="locale" required :value="locale"
                                    @input="updateLocale">
                                    <option v-for="language in languages" v-bind:key="language.id"
                                        :value="language.locale"
                                    >{{language.language}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="row" v-if="loading">
                                <div class="col-xs-4 col-xs-offset-4">
                                    <div class="alert text-center">
                                        <i class="fa fa-spin fa-refresh"></i> Loading
                                    </div>
                                </div>
                            </div>
                            <div class="" v-if="!loading">
                                <div class="form-group">
                                    <label for="title">Question Text</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="txt"
                                        placeholder="Enter Question *"
                                        :value="item.txt"
                                        @input="updateQuestionText"
                                        >
                                </div>
                                    <div class="form-group">
                                        <label for="description">Question Image</label>
                                        <image-file-input ref="imgView" :xprops="xprops"></image-file-input>

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
                                        >
                                    </textarea>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <vue-button-spinner class="btn btn-primary btn-sm" :isLoading="loading" :disabled="loading">
                                        Save
                                    </vue-button-spinner>
                                </div>
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
        module: "TopicQuestionsEdit",
        route: "topic.questions",
        permission_prefix: "topic_question_"
      }
    };
  },
  computed: {
    ...mapGetters("TopicQuestionsSingle", [
      "item",
      "loading",
      "languages",
      "locale"
    ])
  },
  created() {
    this.fetchData(this.$route.params.id);
    this.fetchLanguageData();
  },
  destroyed() {
    this.resetState();
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
      this.fetchLanguageData();
    }
  },
  methods: {
    ...mapActions("TopicQuestionsSingle", [
      "fetchData",
      "fetchLanguageData",
      "updateData",
      "resetState",
      "setQuestionText",
      "setQuestionImage",
      "setAnswerExplanation",
      "setTopicId",
      "setLocale"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    },
    updateQuestionText(e) {
      this.setQuestionText(e.target.value);
    },
    updateAnswerExplanation(e) {
      this.setAnswerExplanation(e.target.value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({
            name: "topic.questions.index",
            params: {
              id: this.item.test_id
            }
          });
          this.$eventHub.$emit("update-success");
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
