<template>
  <div class="vld-parent">
    <loading
      :active.sync="loading"
      :can-cancel="false"
      :color="loadingSetting.color"
      :background-color="loadingSetting.backgroundColor"
      :on-cancel="onCancel"
      :is-full-page="true"
    >
      <slot name="before">
        <div class="vld-icon">
          <svg
            viewBox="0 0 38 38"
            xmlns="http://www.w3.org/2000/svg"
            width="80"
            height="80"
            stroke="#00ff00"
            style="display:block;margin:auto"
          >
            <g fill="none" fill-rule="evenodd">
              <g transform="translate(1 1)" stroke-width="2">
                <circle stroke-opacity="0.25" cx="18" cy="18" r="18"></circle>
                <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(112.315 18 18)">
                  <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="0 18 18"
                    to="360 18 18"
                    dur="0.8s"
                    repeatCount="indefinite"
                  ></animateTransform>
                </path>
              </g>
            </g>
          </svg>
        </div>
        <h1 style="color:white">{{statusMessage}}</h1>
      </slot>
    </loading>
  </div>
</template>
 
<script>
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      isLoading: false,
      loadingSetting: {
        color: "#00ff00",
        backgroundColor: "#000000"
      },
      counter: 0,
      timer: null
    };
  },
  created() {
    var id = this.$route.params.id;
    //if (this.test.id != id) {
      this.isLoading = true;
      console.log('fetching data!');
      this.fetchData(id);
    //}else{
    //this.goToTest();
    //}
  },
  watch: {
    "$route.params.id": function() {
      if (this.test.id == null) {
        this.reset();
        this.isLoading = true;
        this.fetchData(this.$route.params.id);
      }else{
        this.goToTest();
      }
    },
    counter: function() {
      // if (this.counter < -1) {
      //   clearInterval(this.timer);
      //   this.setLoading(false);
      //   if(this.preQuestions.length > 0){
      //     this.$router.push({ name: 'user.test.pre', params:{id: this.test.id} })
      //   }else{
      //     this.$router.push({ name: 'user.test.main', params:{id: this.test.id} })
      //   }
      // }
    },
    loadFlag: function() {
      //load all data and images
      //start counting!!! 3, 2, 1 ...
      // if (this.loadFlag) {
      //   var parent = this;
      //   setTimeout(function() {
      //     parent.timer = setInterval(function() {
      //       console.log("t");
      //       parent.setStatusMessage(parent.counter);
      //       parent.counter--;
      //     }, 1000);
      //   }, 1000);
      // }
    },
    loading: function() {
      if (!this.loading) {
        this.goToTest();
      }
    }
  },
  computed: {
    ...mapGetters("TestData", [
      "test",
      "loading",
      "statusMessage",
      "preQuestions",
      "mainQuestions"
    ])
  },
  components: {
    Loading
  },
  methods: {
    ...mapActions("TestData", [
      "fetchData",
      "resetState",
      "setLoading",
      "setStatusMessage"
    ]),
    goToTest(){
      if (this.preQuestions.length > 0) {
          this.$router.push({
            name: "user.test.pre",
            params: { id: this.$route.params.id }
          });
        } else if(this.mainQuestions.length > 0){
          this.$router.push({
            name: "user.test.main",
            params: { id: this.$route.params.id }
          });
        }
    },
    doAjax() {
      this.isLoading = true;
      // simulate AJAX
      setTimeout(() => {
        this.isLoading = false;
      }, 5000);
    },
    onCancel() {
      console.log("User cancelled the loader.");
    },
    onBefore() {
      console.log("abc");
      return "loading...";
    }
  }
};
</script> 