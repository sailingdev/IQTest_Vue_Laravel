<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Factor</h1>
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
                  v-if="$can('factor_access')"
                  :to="{ name: 'factors.index', params: { id: item.test_id, type:'all' }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Factors
                </router-link>
              </div>

              <bootstrap-alert/>
              <div class="row" v-if="loading">
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                  </div>
                </div>
              </div>
              <div class="box-body" v-if="!loading">
                <div class="form-group">
                  <label for="title">Factor Title</label>
                  <input
                    type="text"
                    class="form-control"
                    name="txt"
                    placeholder="Enter Title *"
                    :value="item.title"
                    @input="updateFactorTitle"
                  >
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="sel1">Select Factor Formula:</label>
                    <select class="form-control" name="type" required @input="updateFormula">
                      <option value="0">Normal</option>
                      <option value="1">log(math)</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="description">Factor Description</label>
                  <textarea
                    rows="3"
                    class="form-control"
                    name="description"
                    placeholder="Enter Description"
                    :value="item.description"
                    @input="updateFactorDescription"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label for="description">Image</label>
                  <image-file-input ref="imgView" v-bind:image.sync="image" :initial="null"></image-file-input>
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
        module: "FactorsCreate",
        route: "factors",
        storeModule: "FactorsSingle",
        permission_prefix: "factor_"
      },
      testId: this.$route.params.id
    };
  },
  created() {
    // Code ...
    this.init();
  },
  computed: {
    ...mapGetters("FactorsSingle", ["item", "loading"])
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
    ...mapActions("FactorsSingle", [
      "storeData",
      "resetState",
      "setFactorTitle",
      "setFactorDescription",
      "setTestId",
      "setFormula",
      "setImage"
    ]),
    init() {
      this.image = null;
      this.resetState();
      //this.resetImage();
      this.setTestId(this.$route.params.id);
    },

    updateFactorTitle(e) {
      this.setFactorTitle(e.target.value);
    },
    updateFactorDescription(e) {
      this.setFactorDescription(e.target.value);
    },
    updateFormula(e) {
      this.setFormula(e.target.value);
    },
    submitForm() {
      this.setImage(this.image);
      this.storeData()
        .then(result => {
          this.$router.push({
            name: "factors.index",
            params: { id: this.testId, type: "all" }
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
