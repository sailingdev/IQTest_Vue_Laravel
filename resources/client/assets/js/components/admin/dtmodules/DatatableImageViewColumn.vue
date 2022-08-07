<template>
  <div>
    <img
      class="my-image"
      :src="row.img_url"
      :alt="row.img_url"
      height="100"
      width="150"
      v-if="row.img_url"
    >
  </div>
</template>

<script>
export default {
  props: ["row", "xprops"],
  data() {
    return {
      // Code...
    };
  },
  created() {
    // Code...
  }
};
</script>
<style>
.my-image {
  border: #a0a0a0;
  border-style: dotted;
}
</style>
