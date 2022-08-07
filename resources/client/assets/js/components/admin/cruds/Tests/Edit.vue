<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Test</h1>
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
                  v-if="item.category_id > 0&&$can('test_access')"
                  :to="{ name: 'tests.index', params: { id: item.category_id }}"
                  class="btn btn-default btn-sm"
                >
                  <span class="glyphicon glyphicon-chevron-left"></span> Back to all Tests
                </router-link>
              </div>

              <bootstrap-alert/>

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
                <div v-if="!loading">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Title *</label>
                        <input
                          type="text"
                          class="form-control"
                          name="title"
                          placeholder="Enter Title *"
                          :value="item.title"
                          @input="updateTitle"
                          required
                        >
                      </div>
                    </div>
                  </div>

                  <div class="form-group" v-if="item.time">
                    <label for="title">Time *</label>
                    <input
                      type="number"
                      class="form-control"
                      name="time"
                      placeholder="Enter Test Time *"
                      :value="item.time"
                      @input="updateTime"
                      required
                    >
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
                  <div class="form-group">
                    <label for="description">Instruction</label>
                    <textarea
                      rows="3"
                      class="form-control"
                      name="description"
                      placeholder="Enter Instruction"
                      :value="item.instruction"
                      @input="updateInstruction"
                    ></textarea>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="description">Certification Background Image</label>
                      <image-file-input
                        ref="imgView"
                        :initial="item.certification_img_url"
                        v-bind:image.sync="certificBackImg"
                      ></image-file-input>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="description">Evaluation Logo Image</label>
                      <image-file-input
                        ref="imgLogoView1"
                        v-bind:image.sync="evaluationLogoImg"
                        :initial="item.evaluation_logo_img_url"
                      ></image-file-input>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="description">Certificate Logo Image</label>
                      <image-file-input
                        ref="imgLogoView2"
                        v-bind:image.sync="certificLogoImg"
                        :initial="item.certific_logo_img_url"
                      ></image-file-input>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="description">Extra PDF Logo Image</label>
                      <image-file-input
                        ref="imgLogoView3"
                        v-bind:image.sync="extraLogoImg"
                        :initial="item.extra_logo_img_url"
                      ></image-file-input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="certificationFile">Certification Blade File</label>
                    <div></div>
                    <button
                      v-if="item.certification_file || item.certification_file_url"
                      class="btn btn-danger"
                      @click="onRemoveCerFile"
                    >Remove</button>
                    <span
                      class="file-row"
                      v-if="item.certification_file || item.certification_file_url"
                    >{{item.certification_file_url}}</span>
                    <input
                      ref="cerFile"
                      type="file"
                      accept=".blade.php"
                      v-on:change="onCerFileChanged"
                      class="form-control"
                    >
                  </div>

                  <div class="form-group">
                    <label for="certificationFile">Extra PDF File</label>
                    <div></div>
                    <button
                      v-if="item.extra_file || item.extra_file_url"
                      class="btn btn-danger"
                      @click="onRemoveExtraFile"
                    >Remove</button>
                    <span
                      class="file-row"
                      v-if="item.extra_file || item.extra_file_url"
                    >{{item.extra_file_url}}</span>
                    <input
                      ref="extraFile"
                      type="file"
                      accept=".pdf"
                      v-on:change="onExtraFileChanged"
                      class="form-control"
                    >
                  </div>
                  <div class="form-group">
                    <label for="title">Initial Price * (USD $)</label>
                    <input
                      type="number"
                      step="any"
                      min="0.01"
                      class="form-control"
                      name="price"
                      placeholder="Enter Initial Price * (USD $)"
                      :value="item.initial_price"
                      @input="updatePrice"
                      required
                    >
                  </div>
                  <div class="form-group">
                    <label for="title">Extra Price (USD $)</label>
                    <input
                      type="number"
                      step="any"
                      class="form-control"
                      name="extraPrice"
                      placeholder="Enter Extra Price (USD $)"
                      :value="item.extra_price"
                      @input="updateExtraPrice"
                    >
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
      certificLogoImg: null,
      evaluationLogoImg: null,
      extraLogoImg: null,
      certificBackImg: null,
      xprops: {
        module: "TestsEdit",
        route: "tests",
        storeModule: "TestsSingle",
        permission_prefix: "test_"
      }
    };
  },
  components: {},
  computed: {
    ...mapGetters("TestsSingle", [
      "item",
      "loading",
      "langLoading",
      "languages",
      "locale"
    ])
  },
  created() {
    this.init();
  },
  destroyed() {
    this.resetState();
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      // this.init();
    }
  },
  methods: {
    ...mapActions("TestsSingle", [
      "fetchData",
      "fetchLanguageData",
      "updateData",
      "resetState",
      "setTitle",
      "setDescription",
      "setTime",
      "setLocale",
      "setInstruction",
      "setCategoryId",
      "setCertificationFile",
      "setExtraFile",
      "setInitialPrice",
      "setExtraPrice",
      "setCertificLogoImg",
      "setEvaluationLogoImg",
      "setExtraLogoImg",
      "setCertificBackImage"
    ]),
    init() {
      console.log("init");
      this.fetchData(this.$route.params.id)
        .then(() => {
          console.log("fatch");
          this.certificBackImg = this.item.certification_img_url;
          this.certificLogoImg = this.item.certific_logo_img_url;
          this.evaluationLogoImg = this.item.evaluation_logo_img_url;
          this.extraLogoImg = this.item.extra_logo_img_url;
          console.log(this.certificLogoImg);
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
    updateTitle(e) {
      this.setTitle(e.target.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    updateTime(e) {
      this.setTime(e.target.value);
    },
    updateInstruction(e) {
      this.setInstruction(e.target.value);
    },
    updatePrice(e) {
      this.setInitialPrice(e.target.value);
    },
    updateExtraPrice(e) {
      this.setExtraPrice(e.target.value);
    },
    onCerFileChanged(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.setCertificationFile(files[0]);
    },
    onExtraFileChanged(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.setExtraFile(files[0]);
    },
    onRemoveCerFile() {
      this.$refs.cerFile.value = null;
      this.setCertificationFile(null);
    },
    onRemoveExtraFile() {
      this.$refs.extraFile.value = null;
      this.setExtraFile(null);
    },
    submitForm() {
      this.setCertificBackImage(this.certificBackImg);
      this.setCertificLogoImg(this.certificLogoImg);
      this.setEvaluationLogoImg(this.evaluationLogoImg);
      this.setExtraLogoImg(this.extraLogoImg);
      this.updateData()
        .then(() => {
          // this.$router.push({
          //   name: "tests.index",
          //   params: {
          //     id: this.item.category_id
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
.file-row {
  background-color: dimgray;
  font-size: 20px;
  color: white;
  padding: 3px;
}
</style>
