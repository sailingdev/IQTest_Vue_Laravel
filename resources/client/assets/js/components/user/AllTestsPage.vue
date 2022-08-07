<template>
  <div>
    <div class="intro-overview">
      <h1>All tests</h1>
      <p>Do you have a specific question or are you looking for a specific test and you don't know where to start? Choose a question from the list below to see which test is right for you.</p>
    </div>
    <div class="row" v-if="loading">
      <div class="col-xs-4 col-xs-offset-4">
        <div class="alert text-center">
          <i class="fa fa-spin fa-refresh"></i> Loading
        </div>
      </div>
    </div>
    <div
      id="container"
      class="isotope"
      style="position: relative; overflow: hidden;"
      v-if="!loading"
    >
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
              >Read more</router-link>
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
    this.setLoading(true);
    this.fetchAllTest();
  },
  beforeRouteLeave(to, from, next) {
    this.resetState();
    next();
  },

  computed: {
    ...mapGetters("TestsIndex", ["allTests", "total", "loading"])
  },
  methods: {
    ...mapActions("TestsIndex", ["fetchAllTest", "resetState", "setLoading"])
  }
};
</script>
