<template>
  <div>
    <TestMainAssessmentPage v-if="test.test_type != 1"></TestMainAssessmentPage>
    <TestMainExamPage v-if="test.test_type == 1"></TestMainExamPage>
  </div>
</template>
<script>
import TestMainAssessmentPage from "./TestMainAssessmentPage";
import TestMainExamPage from "./TestMainExamPage";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    TestMainAssessmentPage,
    TestMainExamPage
  },
  computed: {
    ...mapGetters("TestData", ["test"])
  }
};
</script>

