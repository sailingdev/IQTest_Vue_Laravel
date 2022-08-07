<template>
<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Key Topic Questions</h1>
    </section>

    <section class="content">
        <!-- <div class="panel panel-success">
            <div class="panel-heading">Topic Information</div>
            <div class="panel-body">
                
                    <h2>Title: {{testinfo.title}}</h2>
                
            </div>
        </div> -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">List</h3>
                    </div>
                    <div class="box-body">
                        <back-buttton></back-buttton>
                    </div>
                    <div class="box-body">
                        <div class="btn-group">
                            <router-link v-if="$can(xprops.permission_prefix + 'create')" :to="{ name: xprops.route + '.create', params: { id: topicId }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add new
                            </router-link>
                            <button type="button" class="btn btn-default btn-sm" @click="fetchData(topicId)">
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

                        <datatable v-if="!loading" :columns="columns" :data="data" :total="total" :query="query" :xprops="xprops" filterable />
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
import DatatableAnswerCntColumn from "../../dtmodules/DatatableAnswerCntColumn";
import DatatableImageViewColumn from "../../dtmodules/DatatableImageViewColumn";
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
          title: "Problem",
          field: "txt",
          sortable: true
        },
        {
          title: "Image",
          field: "img_url",
          tdComp: DatatableImageViewColumn
        },
        {
          title: "Correct Answer Explanation",
          field: "correct_ans_exp",
          sortable: true
        },
        {
          title: "Answers",
          field: "answer_cnt",
          tdComp: DatatableAnswerCntColumn,
          sortable: true
        },
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
        module: "TopicQuestionsIndex",
        route: "topic.questions",
        permission_prefix: "topic_question_"
      },
      topicId: this.$route.params.id
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
    ...mapGetters("TopicQuestionsIndex", [
      "data",
      // "testinfo",
      "total",
      "loading",
      "relationships"
    ])
  },
  watch: {
    "$route.params.id": function() {
      console.log(this.$route.params.id);
      console.log("log");
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
    ...mapActions("TopicQuestionsIndex", [
      "fetchData",
      "setQuery",
      "resetState"
    ])
  }
};
</script>

<style scoped>
</style>
