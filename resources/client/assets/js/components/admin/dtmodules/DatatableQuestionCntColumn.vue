<template>
<div>
    <router-link v-if="$can(xprops.permission_prefix + 'view')" :to="{ name: 'questions.index', params: { id: row.id, type: 'all' } }" class="btn btn-success">
        {{row.question_cnt}} Questions
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
