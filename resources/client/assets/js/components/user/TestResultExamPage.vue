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
        <h1 class="results__title">{{ trans('userpage.txt_result_detail_1') }}</h1>
      </div>
      <div class="results__final">
        <div class="results__final-container">
          <div class="box results__final-box">
            <div class="results__score">
              <img class="results__score-image" src="/web_content/img/score.svg" alt="Score">
              <span class="results__score-number">{{item.score}}</span>
            </div>
            <!-- <p class="text-font-color-light">You’re on the 17% of the population</p> -->
            <div class="results__stats">
              <div class="results__stats-item">
                <strong>{{item.totalQuestions}}</strong>
                <span>
                  {{ trans('userpage.txt_result_total') }}
                  <br>
                  {{ trans('userpage.txt_result_question') }}
                </span>
              </div>
              <div class="results__stats-item">
                <strong>{{item.successQuestions}}</strong>
                <span>
                  {{ trans('userpage.txt_result_successful') }}
                  <br>
                  {{ trans('userpage.txt_result_question') }}
                </span>
              </div>
              <div class="results__stats-item">
                <strong>{{item.failedQuestions}}</strong>
                <span>
                  {{ trans('userpage.txt_result_failed') }}
                  <br>
                  {{ trans('userpage.txt_result_question') }}
                </span>
              </div>
              <div class="results__stats-item">
                <strong>{{item.notAnswersQuestions}}</strong>
                <span>
                  {{ trans('userpage.txt_result_not_answered') }}
                  <br>
                  {{ trans('userpage.txt_result_question') }}
                </span>
              </div>
            </div>

            <div class="results__actions">
              <a
                class="results__actions-btn btn-primary btn--large"
                data-turbolinks="false"
                :href="downloadCertification"
              >{{ trans('userpage.txt_result_download_cer_btn') }}</a>
              <a
                class="results__actions-btn btn-secondary btn--large"
                data-turbolinks="false"
                v-if="item.canDownload"
                :href="downloadURL"
              >{{ trans('userpage.txt_result_extra_btn') }}</a>
            </div>
          </div>

          <div class="results__final-footer">
            <div class="results__graph">
              <img src="/web_content/img/graph_color@2x.png" alt="Graph color@2x">
              <strong class="results__graph-title">{{ trans('userpage.txt_result_detail_2') }}</strong>
            </div>
            <p class="text-font-color-light">
              {{ trans('userpage.txt_result_detail_3') }}
              <br>
              {{ trans('userpage.txt_result_detail_4') }}
            </p>
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
      downloadURL:
        "/api/v2/test/" + this.$route.params.token + "/download/extra_test",
      downloadCertification:
        "/api/v2/test/" + this.$route.params.token + "/download/certification"
    };
  },
  computed: {
    ...mapGetters("ResultExamData", ["item", "loading"])
  },
  created() {
    this.fetchData(this.$route.params.token);
  },
  destroyed() {},
  methods: {
    ...mapActions("ResultExamData", ["fetchData"])
  }
};
</script>