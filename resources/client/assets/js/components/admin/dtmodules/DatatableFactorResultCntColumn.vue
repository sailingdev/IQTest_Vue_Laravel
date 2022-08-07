<template>
  <div>
    <router-link
      v-if="$can(xprops.permission_prefix + 'view')&&row.factor_result_cnt!=null"
      :to="{ name: 'factor.results.index', params: { id: row.id } }"
      class="btn btn-warning"
    >{{row.factor_result_cnt}} Results</router-link>
    <p v-if="row.factor_result_cnt == null">*</p>
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
