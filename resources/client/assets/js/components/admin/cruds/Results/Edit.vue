<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Result</h1>
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
                  v-if="item.test_id > 0&&$can('result_access')"
                  :to="{ name: 'results.index', params: { id: item.test_id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Results
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
                <div class v-show="!loading">
                  <div class="form-group">
                    <label for="title">Min Score</label>
                    <input
                      type="number"
                      class="form-control"
                      name="min_score"
                      placeholder="Enter Min Score *"
                      :value="item.min_score"
                      @input="updateMinScore"
                    >
                  </div>
                  <div class="form-group">
                    <label for="title">Max Score</label>
                    <input
                      type="number"
                      class="form-control"
                      name="max_score"
                      placeholder="Enter Max Score *"
                      :value="item.max_score"
                      @input="updateMaxScore"
                    >
                  </div>
                  <div class="form-group">
                    <label for="description">Result Image</label>
                    <image-file-input ref="imgView" :xprops="xprops"></image-file-input>
                  </div>
                  <div class="form-group">
                    <label for="description">Result File</label>
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                      rows="3"
                      class="form-control"
                      name="description"
                      placeholder="Enter Descrition"
                      :value="item.description"
                      @input="updateDescription"
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
        module: "ResultsEdit",
        route: "results",
        permission_prefix: "result_"
      }
    };
  },
  computed: {
    ...mapGetters("ResultsSingle", ["item", "loading", "languages", "locale"])
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
    ...mapActions("ResultsSingle", [
      "fetchData",
      "fetchLanguageData",
      "updateData",
      "resetState",
      "setMinScore",
      "setMaxScore",
      "setDescription",
      "setTestId",
      "setLocale"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    },
    updateMinScore(e) {
      this.setMinScore(e.target.value);
    },
    updateMaxScore(e) {
      this.setMinScore(e.target.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          // this.$router.push({
          //   name: "results.index",
          //   params: {
          //     id: this.item.test_id
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
</style>
