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
    <div v-if="!loading">
      <h1>{{item.title}}</h1>
      <p>
        <em>{{ trans('userpage.txt_updated') }} {{item.updated_at}}</em>
      </p>
      <p>{{item.description}}</p>
      <!-- <div class="span4" style="float: right;">
      <img
        src="https://cdn.123test.com/content/COM/personality_test_cloud_800-600.png"
        alt="Personality test traits"
        title="Personality test traits"
        style="float: right;"
        width="100%"
      >
      </div>-->

      <div id="its123-testAnchor"></div>
      <h4>{{ trans('userpage.txt_instruction') }}</h4>
      <p>{{item.instruction}}</p>
      <div class="row">
        <button class="btn-cta" style="width:30%;float:right" @click="goToTestPage">
          {{ trans('userpage.txt_to_test') }}
          <svg class="iconsvg">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-down"></use>
          </svg>
        </button>
      </div>
    </div>
  </div>
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
    ...mapGetters("TestsSingle", ["item", "loading"])
  },
  watch: {
    "$route.params.id": function() {
      this.resetState();
      this.fetchData(this.$route.params.id);
    }
  },
  methods: {
    ...mapActions("TestsSingle", ["fetchData", "resetState"]),
    goToTestPage() {
      if (this.item.question_cnt > 0) {
        // this.$router.push({
        //   name: "user.test.load",
        //   params: { id: this.item.id }
        // });

        let routeData = this.$router.resolve({
          name: "user.test.load",
          params: { id: this.item.id }
        });
        window.open(routeData.href, "_blank");
      } else {
        alert("There is no question in this test!");
      }
    }
  }
};
</script>
