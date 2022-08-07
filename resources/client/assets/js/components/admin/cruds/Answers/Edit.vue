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
                <h3 class="box-title">Edit</h3>
              </div>

              <div class="box-body">
                <!-- <back-buttton></back-buttton> -->
                <router-link
                  v-if="item.question_id > 0&&$can('answer_access')"
                  :to="{ name: 'answers.index', params: { id: item.question_id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Answers
                </router-link>
              </div>

              <bootstrap-alert/>

              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="sel1">Select Language:</label>
                    <select
                      class="form-control"
                      name="locale"
                      required
                      :value="locale"
                      @input="updateLocale"
                    >
                      <option
                        v-for="language in languages"
                        v-bind:key="language.id"
                        :value="language.locale"
                      >{{language.language}}</option>
                    </select>
                  </div>
                </div>
                <div class="row" v-show="loading">
                  <div class="col-xs-4 col-xs-offset-4">
                    <div class="alert text-center">
                      <i class="fa fa-spin fa-refresh"></i> Loading
                    </div>
                  </div>
                </div>
                <div v-show="!loading">
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
                    <image-file-input
                      ref="imgView"
                      v-bind:image.sync="image"
                      :initial="item.img_url"
                    ></image-file-input>
                  </div>
                  <div class="form-group" v-if="item.score != null">
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
                  </div>

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
                  <!-- only show for Multi Factors Test -->
                  <div style="background-color: beige;padding:5px" v-if="item.factors">
                    <h2>Factors relationship</h2>

                    <div
                      class="row factor-view"
                      v-for="(factor, index) in item.factors"
                      v-bind:key="factor.id"
                    >
                      <div class="col-md-2">
                        <label style="float:right">{{factor.title}}</label>
                      </div>
                      <div class="col-md-1">
                        <input
                          type="number"
                          class="form-control"
                          name="score"
                          step="any"
                          v-model="factorWeights[index]"
                          required
                          max="100"
                          min="-100"
                        >
                      </div>
                    </div>
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
      image: null,
      factorWeights: []
    };
  },
  computed: {
    ...mapGetters("AnswersSingle", ["item", "loading", "languages", "locale"])
  },
  created() {
    this.init();
  },
  destroyed() {
    this.resetState();
  },
  watch: {
    "$route.params.id": function() {
      this.init();
    },
    item: function() {
      if (this.item.id) {
        for (var i in this.item.factors) {
          this.factorWeights.push(this.item.factors[i].weight);
        }
      }
    }
  },
  methods: {
    ...mapActions("AnswersSingle", [
      "fetchData",
      "fetchLanguageData",
      "setLocale",
      "updateData",
      "resetState",
      "setAnswerText",
      "setAnswerImage",
      "setResultText",
      "setAnswerScore",
      "setQuestionId",
      "setFactorWeight",
      "setImage"
    ]),
    init() {
      this.resetState();
      this.fetchData(this.$route.params.id)
        .then(() => {
          this.image = this.item.img_url;
        })
        .catch(error => {
          console.error(error);
        });
      this.fetchLanguageData();
    },
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    },
    updateResultText(e) {
      this.setResultText(e.target.value);
    },
    updateAnswerText(e) {
      this.setAnswerText(e.target.value);
    },
    updateAnswerScore(e) {
      this.setAnswerScore(e.target.value);
    },
    submitForm() {
      this.setFactorWeight(this.factorWeights);
      this.setImage(this.image);
      this.updateData()
        .then(() => {
          // this.$router.push({
          //   name: "answers.index",
          //   params: {
          //     id: this.item.question_id
          //   }
          // });

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
.factor-view {
  padding: 5px;
}
</style>
