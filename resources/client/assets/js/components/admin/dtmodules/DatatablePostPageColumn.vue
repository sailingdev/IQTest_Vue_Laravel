<template>
<div>
    <router-link v-if="$can(xprops.permission_prefix + 'view')" :to="{ name: 'test.postpage.edit', params: { id: row.id} }" class="btn btn-primary">
        {{row.post_question_cnt}} Post Questions
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
