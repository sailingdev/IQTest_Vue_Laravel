<template>
  <div>
    <p v-if="row.score != null">{{row.score}}</p>
    <p v-if="row.score == null">*</p>
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
