<template>
<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Language</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">View</h3>
                    </div>

                    <div class="box-body">
                        <back-buttton></back-buttton>
                    </div>

                    <div class="box-body">
                        <div class="row" v-if="loading">
                            <div class="col-xs-4 col-xs-offset-4">
                                <div class="alert text-center">
                                    <i class="fa fa-spin fa-refresh"></i> Loading
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="!loading">
                            <div class="col-xs-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <td>{{ item.id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Language Name</th>
                                            <td>{{ item.language }}</td>
                                        </tr>
                                        <tr>
                                            <th>Locale Name</th>
                                            <td>{{ item.locale }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
  created() {
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("LanguagesSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
    }
  },
  methods: {
    ...mapActions("LanguagesSingle", ["fetchData", "resetState"])
  }
};
</script>

<style scoped>
</style>
