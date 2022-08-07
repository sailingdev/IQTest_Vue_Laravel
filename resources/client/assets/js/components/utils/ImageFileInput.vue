<template>
  <div>
    <div v-if="img!=null" class="img-container">
      <img :src="img" class="img-responsive my-image" width="200" border="5">
      <button class="btn btn-danger btn-sm button-div" @click="onClearImage">ClearImage</button>

      <!-- <button v-if="xprops.module=='QuestionsEdit'" class="btn btn-primary btn-sm" @click="setDefaultImg">Default</button> -->
    </div>
    <input
      ref="imgInput"
      type="file"
      accept="image/*"
      v-on:change="onImageChange"
      class="form-control"
    >
  </div>
</template>

<script>
export default {
  props: ["initial"],
  data() {
    return {
      img: null
    };
  },
  watch: {
    initial: function(val) {
      this.img = this.initial;
    },
    img: function(val) {
      this.$emit("update:image", val);
      console.log("changed!");
    }
  },
  computed: {},
  created() {
    this.img = this.initial;
    console.log("image file input created!");
    //this.resetState();
  },
  destroyed() {},
  methods: {
    onClearImage() {
      this.$refs.imgInput.value = null;
      this.img = null;
    },
    resetImage() {
      this.$refs.imgInput.value = null;
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      let reader = new FileReader();
      reader.onload = e => {
        this.img = e.target.result;
      };
      reader.readAsDataURL(files[0]);
    }
  }
};
</script>
<style scoped>
.my-image {
  margin: 5px 0px 5px 0px;
  /* display: inline; */
  border: #576562;
  width: 200px;
  height: 150px;
  border-style: dashed;
}
.img-container {
  position: relative;
}
.button-div {
  position: absolute;
  display: inline;
  bottom: 0;
  margin-left: 205px;
}
</style>

