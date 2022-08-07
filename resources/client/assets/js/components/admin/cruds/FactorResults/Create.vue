<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Factor Result</h1>
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
                  v-if="$can('factor_result_access')"
                  :to="{ name: 'factor.results.index', params: { id: item.factor_id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Factor Results
                </router-link>
              </div>

              <bootstrap-alert/>

              <div class="box-body">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input
                    type="text"
                    class="form-control"
                    name="txt"
                    placeholder="Enter Title *"
                    :value="item.title"
                    @input="updateTitle"
                  >
                </div>
                <div class="form-group">
                  <label for="title">Min Score</label>
                  <input
                    type="number"
                    class="form-control"
                    name="min_score"
                    min="0"
                    max="100"
                    placeholder="Enter Min Score *"
                    :value="item.min_score"
                    @input="updateMinScore"
                    required
                  >
                </div>
                <div class="form-group">
                  <label for="title">Max Score</label>
                  <input
                    type="number"
                    class="form-control"
                    name="max_score"
                    min="0"
                    max="100"
                    placeholder="Enter Max Score *"
                    :value="item.max_score"
                    @input="updateMaxScore"
                    required
                  >
                </div>
                <div class="form-group">
                  <label for="description">Result Image</label>
                  <image-file-input ref="imgView" v-bind:image.sync="image" :initial="null"></image-file-input>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea
                    rows="3"
                    class="form-control"
                    name="description"
                    placeholder="Enter Description"
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
      xprops: {
        module: "FactorResultsCreate",
        route: "factor.results",
        storeModule: "FactorResultsSingle",
        permission_prefix: "factor_result_"
      }
    };
  },
  created() {
    // Code ...
    this.init();
  },
  computed: {
    ...mapGetters("FactorResultsSingle", ["item", "loading"])
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
    ...mapActions("FactorResultsSingle", [
      "storeData",
      "resetState",
      "setMinScore",
      "setMaxScore",
      "setDescription",
      "setTitle",
      "setFactorId",
      "setImage"
    ]),
    init() {
      this.image = null;
      this.resetState();
      this.setFactorId(this.$route.params.id);
    },
    updateMinScore(e) {
      this.setMinScore(e.target.value);
    },
    updateMaxScore(e) {
      this.setMaxScore(e.target.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    updateTitle(e) {
      this.setTitle(e.target.value);
    },
    submitForm() {
      this.setImage(this.image);
      this.storeData()
        .then(result => {
          this.$router.push({
            name: "factor.results.index",
            params: { id: this.$route.params.id }
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
