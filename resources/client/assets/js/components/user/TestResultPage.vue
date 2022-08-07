<template>
  <div>
    <TestResultExamPage v-if="testType == 1"></TestResultExamPage>
    <TestResultAssessmentSinglePage v-if="testType == 2"></TestResultAssessmentSinglePage>
    <TestResultAssessmentMultiPage v-if="testType == 3"></TestResultAssessmentMultiPage>
  </div>
</template>
<script>
import TestResultExamPage from "./TestResultExamPage";
import TestResultAssessmentMultiPage from "./TestResultAssessmentMultiPage";
import TestResultAssessmentSinglePage from "./TestResultAssessmentSinglePage";

export default {
  components: {
    TestResultExamPage,
    TestResultAssessmentMultiPage,
    TestResultAssessmentSinglePage
  },
  data() {
    return {
      testType: null
    };
  },
  computed: {},
  created() {
    var token = this.$route.params.token;
    axios
      .get("/api/v2/test/" + token + "/type")
      .then(response => {
        console.log(response);
        this.testType = response.data;
      })
      .catch(error => {
        alert("Error!");
        console.log(error);
      })
      .finally(() => {});
  }
};
</script>

