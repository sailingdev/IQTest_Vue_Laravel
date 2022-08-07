<template>
  <div>
    <p v-if="row.time != null">{{row.time}} mins</p>
    <p v-if="row.time == null">*</p>
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
