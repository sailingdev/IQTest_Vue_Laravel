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
                            <h3 class="box-title">Create</h3>
                        </div>

                        <div class="box-body">
                            <!-- <back-buttton></back-buttton> -->
                            <router-link v-if="$can('result_access')" :to="{ name: 'results.index', params: { id: item.test_id }}" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-chevron-left"></span> Back to all Results
                            </router-link>
                        </div>

                        <bootstrap-alert />

                        <div class="box-body">

                            <div class="form-group">
                                <label for="title">Min Score</label>
                                <input
                                        type="number"
                                        class="form-control"
                                        name="min_score"
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
                                        placeholder="Enter Max Score *"
                                        :value="item.max_score"
                                        @input="updateMaxScore"
                                        required
                                        >
                                </div>
                                    <div class="form-group">
                                        <label for="description">Result Image</label>
                                        <image-file-input ref="imgView" :xprops="xprops"></image-file-input>
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
        module: "ResultsCreate",
        route: "results",
        storeModule: "ResultsSingle",
        permission_prefix: "result_"
      }
    };
  },
  created() {
    // Code ...
    this.resetState();
    this.resetImage();
    this.setTestId(this.$route.params.id);
  },
  computed: {
    ...mapGetters("ResultsSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.resetImage();
      this.setTestId(this.$route.params.id);
    }
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("ResultsSingle", [
      "storeData",
      "resetState",
      "setMinScore",
      "setMaxScore",
      "setDescription",
      "setTestId"
    ]),
    ...mapActions("ImageFileInput", ["resetImage"]),
    updateMinScore(e) {
      this.setMinScore(e.target.value);
    },
    updateMaxScore(e) {
      this.setMaxScore(e.target.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(result => {
          this.$router.push({
            name: "results.index"
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
