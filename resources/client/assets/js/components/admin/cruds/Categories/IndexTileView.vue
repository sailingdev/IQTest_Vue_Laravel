<template>
<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Categories</h1>
    </section>

    <section class="content">
        <div class="row col-xs-12">
            <button type="button" class="btn btn-default btn-sm" @click="fetchData">
                <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
            </button>
        </div>
        <br>
        <div class="row" v-if="loading">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                </div>
            </div>
        </div>
        <div class="row" v-if="!loading">
            <div class="col-md-4" v-for="category in allData" v-bind:key="category.id">
                <div class="box category-card">
                    <div class="quiz-card">
                        <h3 class="quiz-name">{{category.title}}</h3>
                        <p>
                            {{category.description}}
                        </p>
                        <div class="row">
                            <div class="col-xs-6 pad-0">
                                <ul class="topic-detail">
                                    <li>Total Tests <i class="fa fa-long-arrow-right"></i></li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <ul class="topic-detail right">
                                    <li>{{category.test_cnt}}</li>
                                </ul>
                            </div>
                        </div>
                        <router-link :to="{ name: 'tests.index' ,  params: { id: category.id }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Add Test
                        </router-link>
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
  computed: {
    // Code...
    ...mapGetters("CategoriesIndex", [
      "allData",
      "total",
      "loading",
      "relationships"
    ])
  },
  created() {
    // Code...
    this.$root.relationships = this.relationships;
    this.fetchData();
  },
  destroyed() {
    // Code...
  },
  methods: {
    // Code...
    ...mapActions("CategoriesIndex", ["fetchData", "resetState"])
  }
};
</script>

<style scoped>
.category-card {
  padding: 5px 20px 20px 20px;
  box-shadow: 0 7px 15px 0 rgba(0, 0, 0, 0.1);
  background-color: #fff;
  border-top: 3px solid rgba(38, 166, 154, 0.7);
  margin-bottom: 30px;
}

.topic-detail li .fa {
  position: absolute;
  right: 0;
  top: 3.5px;
  color: #26a69a;
}

.topic-detail {
  margin: 10px 0 20px;
  list-style-type: none;
  -webkit-padding-start: 0;
}

.topic-detail li {
  margin-bottom: 6px;
  position: relative;
}
</style>
