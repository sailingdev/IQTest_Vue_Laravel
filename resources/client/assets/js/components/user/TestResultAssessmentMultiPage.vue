<template>
  <div class="main-content">
    <div class="row" v-if="loading">
      <div class="col-xs-4 col-xs-offset-4">
        <div class="alert text-center">
          <i class="fa fa-spin fa-refresh"></i>
          {{ trans('userpage.txt_loading') }}
        </div>
      </div>
    </div>
    <div class="main-content__container" v-if="!loading">
      <div class="results__header">
        <h1 class="results__title">{{item.test_title}} Report</h1>
      </div>

      <div class="results__final">
        <div class="results__final-container">
          <div class="box" style="background-color:#eae9e4;color:white;margin:25px">
            <div class="box__header is-center">
              <h3 class="order__box-title">Visual summary of your results</h3>
            </div>
            <div class="box-content">
              <div
                class="progress"
                v-for="factor in item.factors"
                v-bind:key="factor.id"
                v-bind:class="progressBarColor[Math.floor(factor.weight/25)]"
              >
                <!--<h4>{{factor.weight}}</h4>-->
                <h3 class="progress-title">{{factor.title}}</h3>
                <div class="progress-bar">
                  <div
                    class="progress-value"
                    style="width: 80%;"
                    v-bind:style="{ width: factor.weight + '%' }"
                  >{{factor.weight + '%'}}</div>
                </div>
              </div>
            </div>

            <div class="box__footer"></div>
          </div>

          <div class="results__final-footer">
            <!-- <div class="results__graph">
              <img
                src="https://cdn.123test.com/content/COM/test/personality-test/normal_curve.png"
                alt="normal curve"
                class="normalcurve"
              >
              <strong class="results__graph-title">{{ trans('userpage.txt_result_detail_2') }}</strong>
            </div>-->
            <p class="text-font-color-light">
              {{ trans('userpage.txt_result_detail_3') }}
              <br>
              {{ trans('userpage.txt_result_detail_4') }}
            </p>
            <a
              class="results__actions-btn btn-primary btn--large"
              data-turbolinks="false"
              :href="downloadCertification"
            >{{ trans('userpage.txt_result_download_cer_btn') }}</a>
            <a
              class="results__actions-btn btn-secondary btn--large"
              data-turbolinks="false"
              :href="downloadURL"
              v-if="item.canDownload"
            >{{ trans('userpage.txt_result_extra_btn') }}</a>
            <br>
            <br>
          </div>
        </div>
      </div>

      <section
        class="o-inner-wrapper o-inner-wrapper--narrower"
        v-for="factor in item.factors"
        v-bind:key="factor.id"
      >
        <div>
          <div class="row">
            <div class="c-report-section__image">
              <img :src="factor.img_url" class="question_img center">
            </div>
          </div>
          <div class="c-report-section__top">
            <div class="c-report-section__intro">
              <h1 class="factor_detail_header">{{factor.title}}</h1>
              <p class="factor_detail_content">{{factor.description}}</p>
            </div>

            <div class="c-report-section__scores" style="padding-top:20px">
              <div
                class="c-report-section__score"
                v-bind:style="{background: factor.correct_color}"
              >
                <div class="c-report-section__points">{{factor.weight}} / 100</div>
                <div class="c-report-section__point-category"></div>
              </div>
              <dl class="c-report-section__scoring-legend">
                <div
                  class="c-report-section__legend-row"
                  v-for="(result) in factor.results"
                  v-bind:key="result.id"
                >
                  <dt class="c-report-section__legend-term">
                    {{ result.min_score == 0 ? ("&lt;"+ result.max_score) :
                    ( result.max_score == 100 ? (result.min_score + '+') : (result.min_score + '-' + result.max_score) )}}
                  </dt>
                  <dd class="c-report-section__legend-definition">{{result.title}}</dd>
                </div>
              </dl>
            </div>
          </div>
          <div
            class="c-score-slider js-score-slider noUi-target noUi-ltr noUi-horizontal"
            data-max-score="11"
            data-participant-score="4"
            data-average-score="3.5"
            data-demographic="Other 16-17 year old females"
            disabled="true"
            v-bind:style="{ background: factor.background_color}"
          >
            <div class="noUi-base">
              <div
                class="noUi-base-word prefix"
                v-if="factor.results.length > 0"
              >{{factor.results[0].title}}</div>
              <div class="noUi-connects"></div>
              <div
                class="noUi-origin"
                style="z-index: 6;"
                v-bind:style="{ transform: 'translate('+(factor.weight-100)+'%, 0px)' }"
              >
                <div
                  class="noUi-handle noUi-handle-upper noUi-handle--participantScore"
                  data-handle="1"
                  tabindex="0"
                  role="slider"
                  aria-orientation="horizontal"
                  aria-valuemin="36"
                  aria-valuemax="100"
                  aria-valuenow="36"
                  aria-valuetext="<div class=&quot;tooltip-score&quot;>4</div><div class=&quot;tooltip-label&quot;></div>"
                >
                  <div class="noUi-tooltip" aria-labelledby="participantScore" data-score="4">
                    <div class="tooltip-score">{{factor.weight}}</div>
                    <div class="tooltip-label">You</div>
                  </div>
                </div>
              </div>
              <div
                class="noUi-base-word suffix"
                v-if="factor.results.length > 0"
              >{{factor.results[factor.results.length - 1].title}}</div>
            </div>
            <!-- <div>AAA</div> -->
          </div>
        </div>
      </section>

      <div class="row" hidden>
        <div class="box">
          <div class="box__header is-center">
            <h2 class="order__box-title">Factor Description</h2>
          </div>
          <div class="box-content">
            <div class="row factor-detail" v-for="factor in item.factors" v-bind:key="factor.id">
              <div class="col-md-3">
                <img
                  :src="factor.img_url"
                  :alt="factor.img_url"
                  height="100"
                  width="150"
                  class="my-image"
                >
              </div>
              <div class="col-md-9">
                <h1>{{factor.title}}</h1>
                <span>{{factor.description}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <i class="scroll-down active" data-scroll=".footer"></i>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      progressBarColor: ["yellow", "green", "blue", "red", "red"],
      downloadURL:
        "/api/v2/test/" + this.$route.params.token + "/download/extra_test",
      downloadCertification:
        "/api/v2/test/" + this.$route.params.token + "/download/certification",
      background1:
        "linear-gradient(90deg,  #eb5c21 0,#eb5c21 60%, #e99673 0,#e99673 69%, #9fc90f 0,#9fc90f 78%, #f89821 0,#f89821"
    };
  },
  computed: {
    ...mapGetters("ResultMultiData", ["item", "loading"]),
    classObject: function() {
      return {
        active: this.isActive && !this.error,
        "text-danger": this.error && this.error.type === "fatal"
      };
    }
  },
  created() {
    this.fetchData(this.$route.params.token)
      .then(result => {})
      .catch(error => {});
  },
  mounted() {},
  destroyed() {},
  methods: {
    ...mapActions("ResultMultiData", ["fetchData"])
  }
};
</script>
<style scoped>
@import "../../../css/progressbar.css";
/* @import "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"; */
@import "../../../css/bootstrap.min.css";
.box__header {
  background-color: hotpink !important;
}

.progressbar {
  /* box-sizing: unset !important; */
}
h1 {
  font-weight: bold;
  color: #606060;
}
.my-image {
  border: #a0a0a0;
  border-style: dotted;
  margin: 25px;
}
.factor-detail {
  padding: 10px;
}
.o-inner-wrapper--narrower {
  max-width: 948px;
}

@media (min-width: 768px) {
  .o-inner-wrapper {
    padding-left: 24px;
    padding-right: 24px;
  }
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
.question_img {
  /* min-height: 300px; */
  max-height: 350px;
  object-fit: contain;
  width: auto;
  /* border-style: ridge !important; */
  padding: 10px;
  /* border: #f0f0f0; */
}

.o-inner-wrapper {
  margin-right: auto;
  margin-left: auto;
  max-width: 1328px;
  padding-left: 16px;
  padding-right: 16px;
}
.factor_detail_header {
  color: black !important;
  margin-bottom: 1.2em;
}
.factor_detail_content {
  font-size: 19px;
}
</style>
