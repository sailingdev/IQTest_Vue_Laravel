<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Factor</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View</h3>
            </div>

            <div class="box-body">
              <!-- <back-buttton></back-buttton> -->
              <router-link
                v-if="item.test_id > 0&&$can('factor_access')"
                :to="{ name: 'factors.index', params: { id: item.test_id,type:'all' }}"
                class="btn btn-default btn-sm"
              >
                <span class="glyphicon glyphicon-chevron-left"></span> Back to all Factors
              </router-link>
            </div>

            <div class="box-body">
              <div class="row">
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
              <div class="row" v-if="!loading">
                <div class="col-xs-6">
                  <table class="table table-bordered table-striped">
                    <tbody>
                      <tr>
                        <th>#</th>
                        <td>{{ item.id }}</td>
                      </tr>
                      <tr>
                        <th>Title</th>
                        <td>{{ item.title }}</td>
                      </tr>
                      <tr>
                        <th>Formula</th>
                        <td>{{ item.formula == 0 ? "Normal" : "log(math)" }}</td>
                      </tr>
                      <tr>
                        <th>Description</th>
                        <td>{{ item.description }}</td>
                      </tr>
                      <tr>
                        <th>Image</th>
                        <td>
                          <img :src="item.img_url" height="100" width="150" class="my-image">
                        </td>
                      </tr>
                      <tr>
                        <th>Results</th>
                        <td>
                          <router-link
                            v-if="$can('factor_result_view')"
                            :to="{ name: 'factor.results.index', params: { id: item.id } }"
                            class="btn btn-warning"
                          >{{item.factor_result_cnt}} Results</router-link>
                        </td>
                      </tr>
                      <tr>
                        <th>Created At</th>
                        <td>{{ item.created_at }}</td>
                      </tr>
                      <tr>
                        <th>Updated At</th>
                        <td>{{ item.updated_at }}</td>
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
    this.fetchLanguageData();
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("FactorsSingle", ["item", "loading", "languages", "locale"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
      this.fetchLanguageData();
    }
  },
  methods: {
    ...mapActions("FactorsSingle", [
      "fetchData",
      "resetState",
      "setLocale",
      "fetchLanguageData"
    ]),
    updateLocale(e) {
      this.setLocale(e.target.value);
      this.fetchData(this.$route.params.id);
    }
  }
};
</script>

<style scoped>
.my-image {
  border: #f0a0a0;
  border-style: dotted;
}
</style>
