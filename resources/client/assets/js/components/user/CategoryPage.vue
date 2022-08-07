<template>
  <div>
    <div class="row" v-if="loading">
      <div class="col-xs-4 col-xs-offset-4">
        <div class="alert text-center">
          <i class="fa fa-spin fa-refresh"></i>
          {{ trans('userpage.txt_loading') }}
        </div>
      </div>
    </div>
    <div class="intro-overview" v-if="allTests.length > 0">
      <h1>{{allTests[0].category_title}}</h1>
    </div>
    <div
      id="container"
      class="isotope"
      style="position: relative; overflow: hidden;"
      v-if="!loading"
    >
      <h3 v-if="allTests.length == 0 && !loading">{{ trans('userpage.txt_no_test') }}</h3>
      <div
        class="element persoonlijkheid recommended isotope-item expanded-view"
        v-for="test in allTests"
        v-bind:key="test.id"
      >
        <div class="feature-box">
          <div class="feature-box-icon">
            <div class="icon-arrow-right"></div>
          </div>
          <div class="feature-box-info">
            <h3 class="shorter">
              <router-link
                :to="{ name: 'user.test.detail' , params: {id: test.id}}"
                class="itsAjaxLoader"
              >{{test.title}}</router-link>

              <!-- <a href="/personality-test/" class="itsAjaxLoader">{{test.title}}</a> -->
              <a
                class="pull-right cubes itsAjaxLoader"
                rel="tooltip"
                data-placement="bottom"
                data-original-title="Extended test "
              >
                <svg class="iconsvg icon-rating-cube">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rating-cube"></use>
                </svg>
                <svg class="iconsvg icon-rating-cube">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rating-cube"></use>
                </svg>
                <svg class="iconsvg icon-rating-cube">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rating-cube"></use>
                </svg>
                <svg class="iconsvg icon-rating-cube">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rating-cube"></use>
                </svg>
                <svg class="iconsvg icon-rating-cube">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rating-cube"></use>
                </svg>
              </a>
            </h3>
            <p class="tall">
              {{test.description}}
              <router-link
                :to="{ name: 'user.test.detail' , params: {id: test.id}}"
                class="itsAjaxLoader"
              >{{ trans('userpage.txt_more_btn') }}</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {};
  },
  created() {
    this.fetchData(this.$route.params.id);
  },
  computed: {
    ...mapGetters("TestsIndex", ["allTests", "total", "loading"])
  },
  beforeRouteLeave(to, from, next) {
    this.resetState();
    next();
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
    }
  },
  methods: {
    ...mapActions("TestsIndex", ["fetchData", "resetState"])
  }
};
</script>
