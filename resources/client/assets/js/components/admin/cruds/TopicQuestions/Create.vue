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
                            <h3 class="box-title">Create</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <bootstrap-alert />

                        <div class="box-body">

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
                                    <image-file-input ref="imgView"  :xprops="xprops"></image-file-input>
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
        module: "TopicQuestionsCreate",
        route: "topic.questions",
        storeModule: "TopicQuestionsSingle",
        permission_prefix: "topic_question_"
      }
    };
  },
  created() {
    // Code ...
    this.resetState();
    this.resetImage();
    this.setTopicId(this.$route.params.id);
  },
  computed: {
    ...mapGetters("TopicQuestionsSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.resetImage();
      this.setTopicId(this.$route.params.id);
    }
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("TopicQuestionsSingle", [
      "storeData",
      "resetState",
      "setQuestionText",
      "setAnswerExplanation",
      "setTopicId"
    ]),
    ...mapActions("ImageFileInput", ["resetImage"]),
    updateQuestionText(e) {
      this.setQuestionText(e.target.value);
    },
    updateAnswerExplanation(e) {
      this.setAnswerExplanation(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(result => {
          //   this.$router.push({
          //     name: "questions.create"
          //   });

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
