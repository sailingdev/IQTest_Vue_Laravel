<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Question</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View</h3>
            </div>

            <div class="box-body">
              <!-- <back-buttton></back-buttton> -->
              <router-link
                v-if="item.test_id > 0&&$can('question_access')"
                :to="{ name: 'questions.index', params: { id: item.test_id,type:'all' }}"
                class="btn btn-default btn-sm"
              >
                <span class="glyphicon glyphicon-chevron-left"></span> Back to all Questions
              </router-link>
            </div>

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
              <div class="row" v-if="loading">
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                  </div>
                </div>
              </div>
              <div class="row" v-if="!loading">
                <div class="col-xs-6">
                  <table class="table table-bordered table-striped">
                    <tbody>
                      <tr>
                        <th>#</th>
                        <td>{{ item.id }}</td>
                      </tr>
                      <tr>
                        <th>Problem</th>
                        <td>{{ item.txt }}</td>
                      </tr>
                      <tr>
                        <th>Key Topic</th>
                        <td>{{ item.topic_name }}</td>
                      </tr>
                      <tr>
                        <th>Page</th>
                        <td>{{ item.page }}</td>
                      </tr>
                      <tr>
                        <th>Question Type</th>
                        <td>{{ item.question_type == 0 ? "Single Choice" : "Multiple Choice" }}</td>
                      </tr>
                      <tr>
                        <th>Image</th>
                        <td>
                          <img :src="item.img_url" height="100" width="150" class="my-image">
                        </td>
                      </tr>
                      <tr>
                        <th>Correct Answer Explanation</th>
                        <td>{{ item.correct_ans_exp }}</td>
                      </tr>
                      <tr>
                        <th>Answers</th>
                        <td v-if="item.answer_cnt !== null">
                          <router-link
                            v-if="$can('answer_view')"
                            :to="{ name: 'answers.index', params: { id: item.id } }"
                            class="btn btn-success"
                          >{{item.answer_cnt}} Answers</router-link>
                        </td>
                      </tr>
                      <tr>
                        <th>Created At</th>
                        <td>{{ item.created_at }}</td>
                      </tr>
                      <tr>
                        <th>Updated At</th>
                        <td>{{ item.updated_at }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
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
    };
  },
  created() {
    this.fetchData(this.$route.params.id);
    this.fetchLanguageData();
    this.fetchKeyTopicData();
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("QuestionsSingle", ["item", "loading", "languages", "locale"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
      this.fetchLanguageData();
      this.fetchKeyTopicData();
    }
  },
  methods: {
    ...mapActions("QuestionsSingle", [
      "fetchData",
      "resetState",
      "setLocale",
      "fetchLanguageData",
      "fetchKeyTopicData"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    }
  }
};
</script>

<style scoped>
.my-image {
  border: #f0a0a0;
  border-style: dotted;
}
</style>
