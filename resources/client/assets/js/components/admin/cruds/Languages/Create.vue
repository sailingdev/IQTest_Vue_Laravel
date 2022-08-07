<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Language</h1>
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
                <back-buttton></back-buttton>
              </div>

              <bootstrap-alert/>

              <div class="box-body">
                <div class="form-group">
                  <label for="title">Language Name*</label>
                  <input
                    type="text"
                    class="form-control"
                    name="language"
                    placeholder="Enter Language *"
                    :value="item.language"
                    @input="updateLanguageName"
                    required
                  >
                </div>
                <div class="form-group">
                  <label for="title">Locale Name *</label>
                  <input
                    type="text"
                    class="form-control"
                    name="locale"
                    placeholder="Enter Locale Name *"
                    :value="item.locale"
                    @input="updateLocaleName"
                    required
                  >
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
    ...mapGetters("LanguagesSingle", ["item", "loading"])
  },
  created() {
    // Code ...
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("LanguagesSingle", [
      "storeData",
      "resetState",
      "setLanguageName",
      "setLocaleName"
    ]),
    updateLanguageName(e) {
      this.setLanguageName(e.target.value);
    },
    updateLocaleName(e) {
      this.setLocaleName(e.target.value);
    },

    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({
            name: "languages.index"
          });
          this.$eventHub.$emit("create-success");
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
