<template>
<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Key Topic</h1>
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

                        <bootstrap-alert />

                        <div class="box-body">

                            <div class="form-group">
                                <label for="title">Topic name</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        placeholder="Enter Topic Name *"
                                        :value="item.name"
                                        @input="updateName"
                                        required
                                        >
                                </div>
                                 <!-- <div class="form-group">
                                        <label for="value">Topic Value</label>
                                        <textarea
                                        rows="3"
                                        class="form-control"
                                        name="value"
                                        placeholder="Enter Value"
                                        :value="item.value"
                                        @input="updateValue"
                                        required
                                        >
                                    </textarea>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="description">Topic Description</label>
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
        module: "TopicsCreate",
        route: "topics",
        storeModule: "TopicsSingle",
        permission_prefix: "topic_"
      }
    };
  },
  created() {
    // Code ...
    this.resetState();
    this.resetImage();
  },
  computed: {
    ...mapGetters("TopicsSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.resetImage();
    }
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions("TopicsSingle", [
      "storeData",
      "resetState",
      "setName",
      "setValue",
      "setDescription"
    ]),
    ...mapActions("ImageFileInput", ["resetImage"]),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateValue(e) {
      this.setValue(e.target.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(result => {
          this.$router.push({
            name: "topics.index"
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
