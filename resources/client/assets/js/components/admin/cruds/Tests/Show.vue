<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Test</h1>
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
                v-if="item.category_id > 0&&$can('test_access')"
                :to="{ name: 'tests.index', params: { id: item.category_id }}"
                class="btn btn-default btn-sm"
              >
                <span class="glyphicon glyphicon-chevron-left"></span> Back to all Tests
              </router-link>
            </div>

            <div class="box-body">
              <div class="row" v-if="!langLoading">
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
                        <th>Title</th>
                        <td>{{ item.title }}</td>
                      </tr>
                      <tr>
                        <th>Description</th>
                        <td>{{ item.description }}</td>
                      </tr>
                      <tr>
                        <th>Instruction</th>
                        <td>{{ item.instruction }}</td>
                      </tr>
                      <tr v-if="item.time">
                        <th>Test Time</th>
                        <td>{{ item.time }}mins</td>
                      </tr>
                      <tr>
                        <th>Initial Price</th>
                        <td>{{ item.initial_price }}$</td>
                      </tr>
                      <tr>
                        <th>Extra Price</th>
                        <td>{{ item.extra_price }}$</td>
                      </tr>

                      <tr v-if="item.factor_cnt!=null">
                        <th>Factors</th>
                        <td>
                          <router-link
                            v-if="$can('factor_view')"
                            :to="{ name: 'factors.index', params: { id: item.id} }"
                            class="btn btn-success"
                          >{{item.factor_cnt}} Factors</router-link>
                        </td>
                      </tr>
                      <tr>
                        <th>Questions</th>
                        <td>
                          <router-link
                            v-if="$can('question_view')"
                            :to="{ name: 'questions.index', params: { id: item.id , type:'all'} }"
                            class="btn btn-success"
                          >{{item.question_cnt}} Questions</router-link>
                        </td>
                      </tr>
                      <tr>
                        <th>Pre Page</th>
                        <td>
                          <router-link
                            :to="{ name: 'test.prepage.edit', params: { id: item.id } }"
                            class="btn btn-danger"
                          >{{item.pre_question_cnt}} Pre Questions</router-link>
                        </td>
                      </tr>
                      <tr>
                        <th>Post Page</th>
                        <td>
                          <router-link
                            :to="{ name: 'test.postpage.edit', params: { id: item.id } }"
                            class="btn btn-primary"
                          >{{item.post_question_cnt}} Post Questions</router-link>
                        </td>
                      </tr>
                      <tr v-if="item.result_cnt">
                        <th>Results</th>
                        <td>
                          <router-link
                            v-if="$can('result_view')"
                            :to="{ name: 'results.index', params: { id: item.id } }"
                            class="btn btn-warning"
                          >{{item.result_cnt}} Results</router-link>
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
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("TestsSingle", [
      "item",
      "loading",
      "langLoading",
      "languages",
      "locale"
    ])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
    }
  },
  methods: {
    ...mapActions("TestsSingle", [
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
</style>
