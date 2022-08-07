<template>
<div>
    <router-link v-if="$can(xprops.permission_prefix + 'view')" :to="{ name: 'answers.index', params: { id: row.id } }" class="btn btn-success">
        {{row.answer_cnt}} Answers
    </router-link>
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
