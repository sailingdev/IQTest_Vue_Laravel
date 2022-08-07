<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Tests</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List</h3>
            </div>
            <div class="box-body">
              <!-- <back-buttton></back-buttton> -->
              <router-link
                v-if="$can('category_access')"
                :to="{ name: 'category.tile.index'}"
                class="btn btn-default btn-sm"
              >
                <span class="glyphicon glyphicon-chevron-left"></span> Back to Categories
              </router-link>
            </div>
            <div class="box-body">
              <div class="btn-group">
                <router-link
                  v-if="$can(xprops.permission_prefix + 'create')"
                  :to="{ name: xprops.route + '.create', params: { id: categoryId }}"
                  class="btn btn-success btn-sm"
                >
                  <i class="fa fa-plus"></i> Add new
                </router-link>
                <button type="button" class="btn btn-default btn-sm" @click="fetchData(categoryId)">
                  <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                </button>
              </div>
            </div>

            <div class="box-body">
              <div class="row" v-if="loading">
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                  </div>
                </div>
              </div>

              <datatable
                v-if="!loading"
                :columns="columns"
                :data="data"
                :total="total"
                :query="query"
                :xprops="xprops"
                filterable
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import DatatableActions from "../../dtmodules/DatatableActions";
import DatatableTimeColumn from "../../dtmodules/DatatableTimeColumn";
import DatatableQuestionCntColumn from "../../dtmodules/DatatableQuestionCntColumn";
import DatatableResultCntColumn from "../../dtmodules/DatatableResultCntColumn";
import DatatableKeyTopicCntColumn from "../../dtmodules/DatatableKeyTopicCntColumn";
import DataTablePostPageColumn from "../../dtmodules/DataTablePostPageColumn";
import DataTablePrePageColumn from "../../dtmodules/DataTablePrePageColumn";
import DatatableSingle from "../../dtmodules/DatatableSingle";
import DatatableList from "../../dtmodules/DatatableList";
import DatatableCheckbox from "../../dtmodules/DatatableCheckbox";

export default {
  data() {
    return {
      columns: [
        {
          title: "#",
          field: "id",
          sortable: true,
          colStyle: "width: 50px;"
        },
        {
          title: "Title",
          field: "title",
          sortable: true,
          colStyle: "width: 10%;"
        },
        // {
        //   title: "Description",
        //   field: "description",
        //   sortable: true,
        //   colStyle: "width: 20%;"
        // },
        // {
        //   title: "Instruction",
        //   field: "instruction",
        //   sortable: true
        // },
        {
          title: "Test Time",
          field: "time",
          tdComp: DatatableTimeColumn,
          sortable: true,
          colStyle: "width: 120px;"
        },
        {
          title: "Pre Page",
          field: "pre_question_cnt",
          tdComp: DataTablePrePageColumn
          // sortable: true
        },
        {
          title: "Post Page",
          field: "post_question_cnt",
          tdComp: DataTablePostPageColumn
          // sortable: true
        },
        {
          title: "Category",
          field: "category_title",
          colStyle: "width: 120px"
        },
        {
          title: "Questions",
          field: "question_cnt",
          tdComp: DatatableQuestionCntColumn,
          sortable: true
        },
        {
          title: "Results",
          field: "result_cnt",
          tdComp: DatatableResultCntColumn,
          sortable: true
        },
        // {
        //   title: "Topics",
        //   field: "topic_cnt",
        //   tdComp: DatatableKeyTopicCntColumn,
        //   sortable: true
        // },
        {
          title: "Actions",
          tdComp: DatatableActions,
          visible: true,
          thClass: "text-right",
          tdClass: "text-right",
          colStyle: "width: 130px;"
        }
      ],
      query: {
        sort: "id",
        order: "desc"
      },
      xprops: {
        module: "TestsIndex",
        route: "tests",
        permission_prefix: "test_"
      },
      categoryId: this.$route.params.id
    };
  },
  created() {
    this.$root.relationships = this.relationships;
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("TestsIndex", ["data", "total", "loading", "relationships"])
  },
  watch: {
    "$route.params.id": function() {
      this.fetchData(this.$route.params.id);
    },
    query: {
      handler(query) {
        this.setQuery(query);
      },
      deep: true
    }
  },
  methods: {
    ...mapActions("TestsIndex", ["fetchData", "setQuery", "resetState"])
  }
};
</script>

<style scoped>
</style>
