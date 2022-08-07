<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Post Page</h1>
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
                  v-if="item.id > 0"
                  :to="{ name: 'tests.show', params: { id: item.id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to Test
                </router-link>
              </div>

              <bootstrap-alert/>

              <div class="box-body">
                <div class="row" v-show="!langLoading">
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
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Title *</label>
                        <input
                          type="text"
                          class="form-control"
                          name="title"
                          placeholder="Enter Title *"
                          :value="item.post_page_title"
                          @input="updatePostPageTitle"
                          required
                        >
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                      rows="3"
                      class="form-control"
                      name="description"
                      placeholder="Enter Description"
                      :value="item.post_page_desc"
                      @input="updatePostPageDescription"
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label for>Post Questions</label>
                    <br>
                    <router-link
                      v-if="$can('question_view')"
                      :to="{ name: 'questions.index', params: { id: item.id,type:'post' } }"
                      class="btn btn-success"
                    >{{item.post_question_cnt}} Questions</router-link>
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
    };
  },
  computed: {
    ...mapGetters("TestsPageSingle", [
      "item",
      "loading",
      "langLoading",
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
    ...mapActions("TestsPageSingle", [
      "fetchData",
      "fetchLanguageData",
      "updateData",
      "resetState",
      "setPostPageTitle",
      "setPostPageDescription",
      "setLocale",
      "setCategoryId"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    },
    updatePostPageTitle(e) {
      this.setPostPageTitle(e.target.value);
    },
    updatePostPageDescription(e) {
      this.setPostPageDescription(e.target.value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          // this.$router.push({
          //   name: "tests.show",
          //   params: {
          //     id: this.item.id
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
