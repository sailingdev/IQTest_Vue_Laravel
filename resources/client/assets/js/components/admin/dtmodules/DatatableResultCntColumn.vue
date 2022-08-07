<template>
  <div>
    <router-link
      v-if="$can(xprops.permission_prefix + 'view')&&row.result_cnt!=null"
      :to="{ name: 'results.index', params: { id: row.id } }"
      class="btn btn-warning"
    >{{row.result_cnt}} Results</router-link>
    <p v-if="row.result_cnt == null">*</p>
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
