<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Answer</h1>
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
                v-if="item.question_id > 0&&$can('answer_access')"
                :to="{ name: 'answers.index', params: { id: item.question_id }}"
                class="btn btn-default btn-sm"
              >
                <span class="glyphicon glyphicon-chevron-left"></span> Back to all Answers
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
                        <th>Answer Text</th>
                        <td>{{ item.txt }}</td>
                      </tr>
                      <tr>
                        <th>Answer Image</th>
                        <td>
                          <img :src="item.img_url" height="100" width="150" class="my-image">
                        </td>
                      </tr>
                      <tr v-if="item.score != null">
                        <th>Answer Score (weight)</th>
                        <td>{{ item.score }}</td>
                      </tr>
                      <tr>
                        <th>Result Text</th>
                        <td>{{ item.result_text }}</td>
                      </tr>

                      <tr v-if="item.factors">
                        <th>
                          <h3>Factors relationship</h3>
                        </th>
                      </tr>
                      <tr v-for="factor in item.factors" v-bind:key="factor.id" class="factor-row">
                        <th>{{factor.title}}</th>
                        <td>{{factor.weight}}</td>
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
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("AnswersSingle", ["item", "loading", "languages", "locale"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
      this.fetchLanguageData();
    }
  },
  methods: {
    ...mapActions("AnswersSingle", [
      "fetchData",
      "resetState",
      "setLocale",
      "fetchLanguageData"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    }
  }
};
</script>

<style scoped>
.factor-row {
  background-color: bisque !important;
}
.my-image {
  border: #f0a0a0;
  border-style: dotted;
}
</style>
