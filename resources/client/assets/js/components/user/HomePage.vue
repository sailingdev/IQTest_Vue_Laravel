<template>
  <article>
    <!--start article main-->
    <h1>{{ trans('userpage.txt_home_title') }}</h1>
    <p>{{ trans('userpage.txt_home_header') }}</p>

    <div v-for="category in categories" v-bind:key="category.id">
      <h2>{{category.title}}</h2>
      <div class="insert align-right" v-if="category.test_cnt>0">
        <h2>{{category.question}}</h2>
        <p>{{category.short_desc}}</p>
        <router-link
          :to="{ name: 'user.category' , params: {id: category.id}}"
          class="btn btn-primary btn-block"
        >{{ trans('userpage.txt_home_test_btn') }}</router-link>
      </div>
      <p>{{category.description}}</p>
      <p style="clear: both;"></p>
    </div>
  </article>
</template>

<script>
export default {
  data() {
    return {
      categories: window.laravel.categories
    };
  }
};
</script>
