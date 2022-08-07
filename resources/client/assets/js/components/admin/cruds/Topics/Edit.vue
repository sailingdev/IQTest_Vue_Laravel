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
                        <div class="box-body" v-if="!loading">

                            <div class="form-group">
                                <label for="title">Key Topic Name</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        placeholder="Enter Key Topic Name *"
                                        :value="item.name"
                                        @input="updateName"
                                        >
                                </div>
                                <!-- <div class="form-group">
                                    <label for="value">Value</label>
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

                                <div class="box-footer">
                                    <vue-button-spinner class="btn btn-primary btn-sm" :isLoading="loading" :disabled="loading">
                                        Save
                                    </vue-button-spinner>
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
        module: "TopicsEdit",
        route: "topics",
        permission_prefix: "topic_"
      }
    };
  },
  computed: {
    ...mapGetters("TopicsSingle", ["item", "loading"])
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
    ...mapActions("TopicsSingle", [
      "fetchData",
      "updateData",
      "resetState",
      "setName",
      "setValue",
      "setDescription"
    ]),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateValue(e) {
      this.setValue(e.targetl.value);
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({
            name: "topics.index"
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
