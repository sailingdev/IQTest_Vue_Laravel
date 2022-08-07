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
                            <h3 class="box-title">Edit</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <bootstrap-alert />
                        <div class="row" v-if="loading">
                            <div class="col-xs-4 col-xs-offset-4">
                                <div class="alert text-center">
                                    <i class="fa fa-spin fa-refresh"></i> Loading
                                </div>
                            </div>
                        </div>
                        <div class="box-body"  v-if="!loading">

                            <div class="form-group">
                                <label for="title">Language Name *</label>
                                <input
                                            type="text"
                                            class="form-control"
                                            name="language"
                                            placeholder="Enter Language Name *"
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
    };
  },
  computed: {
    ...mapGetters("LanguagesSingle", ["item", "loading"])
  },
  created() {
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
    }
  },
  methods: {
    ...mapActions("LanguagesSingle", [
      "resetState",
      "fetchData",
      "updateData",
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
      this.updateData()
        .then(() => {
          this.$router.push({
            name: "languages.index"
          });
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
