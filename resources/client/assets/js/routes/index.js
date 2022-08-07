import Vue from 'vue'
import VueRouter from 'vue-router'

import ChangePassword from '../components/utils/ChangePassword.vue'
import CategoriesIndex from '../components/admin/cruds/Categories/Index.vue'
import CategoriesIndexTileView from '../components/admin/cruds/Categories/IndexTileView.vue'
import CategoriesCreate from '../components/admin/cruds/Categories/Create.vue'
import CategoriesShow from '../components/admin/cruds/Categories/Show.vue'
import CategoriesEdit from '../components/admin/cruds/Categories/Edit.vue'
import TestsIndex from '../components/admin/cruds/Tests/Index.vue'
import TestsCreate from '../components/admin/cruds/Tests/Create.vue'
import TestsShow from '../components/admin/cruds/Tests/Show.vue'
import TestsEdit from '../components/admin/cruds/Tests/Edit.vue'

import QuestionsIndex from '../components/admin/cruds/Questions/Index.vue'
import QuestionsCreate from '../components/admin/cruds/Questions/Create.vue'
import QuestionsShow from '../components/admin/cruds/Questions/Show.vue'
import QuestionsEdit from '../components/admin/cruds/Questions/Edit.vue'

import FactorsIndex from '../components/admin/cruds/Factors/Index.vue'
import FactorsCreate from '../components/admin/cruds/Factors/Create.vue'
import FactorsShow from '../components/admin/cruds/Factors/Show.vue'
import FactorsEdit from '../components/admin/cruds/Factors/Edit.vue'

import FactorResultsIndex from '../components/admin/cruds/FactorResults/Index.vue'
import FactorResultsCreate from '../components/admin/cruds/FactorResults/Create.vue'
import FactorResultsShow from '../components/admin/cruds/FactorResults/Show.vue'
import FactorResultsEdit from '../components/admin/cruds/FactorResults/Edit.vue'


import TopicQuestionsIndex from '../components/admin/cruds/TopicQuestions/Index.vue'
import TopicQuestionsCreate from '../components/admin/cruds/TopicQuestions/Create.vue'
import TopicQuestionsShow from '../components/admin/cruds/TopicQuestions/Show.vue'
import TopicQuestionsEdit from '../components/admin/cruds/TopicQuestions/Edit.vue'

import TopicsIndex from '../components/admin/cruds/Topics/Index.vue'
import TopicsCreate from '../components/admin/cruds/Topics/Create.vue'
import TopicsShow from '../components/admin/cruds/Topics/Show.vue'
import TopicsEdit from '../components/admin/cruds/Topics/Edit.vue'

import ResultsIndex from '../components/admin/cruds/Results/Index.vue'
import ResultsCreate from '../components/admin/cruds/Results/Create.vue'
import ResultsShow from '../components/admin/cruds/Results/Show.vue'
import ResultsEdit from '../components/admin/cruds/Results/Edit.vue'

import AnswersIndex from '../components/admin/cruds/Answers/Index.vue'
import AnswersCreate from '../components/admin/cruds/Answers/Create.vue'
import AnswersShow from '../components/admin/cruds/Answers/Show.vue'
import AnswersEdit from '../components/admin/cruds/Answers/Edit.vue'

import PermissionsIndex from '../components/admin/cruds/Permissions/Index.vue'
import PermissionsCreate from '../components/admin/cruds/Permissions/Create.vue'
import PermissionsShow from '../components/admin/cruds/Permissions/Show.vue'
import PermissionsEdit from '../components/admin/cruds/Permissions/Edit.vue'
import RolesIndex from '../components/admin/cruds/Roles/Index.vue'
import RolesCreate from '../components/admin/cruds/Roles/Create.vue'
import RolesShow from '../components/admin/cruds/Roles/Show.vue'
import RolesEdit from '../components/admin/cruds/Roles/Edit.vue'
import UsersIndex from '../components/admin/cruds/Users/Index.vue'
import UsersCreate from '../components/admin/cruds/Users/Create.vue'
import UsersShow from '../components/admin/cruds/Users/Show.vue'
import UsersEdit from '../components/admin/cruds/Users/Edit.vue'


import LanguagesIndex from '../components/admin/cruds/Languages/Index.vue'
import LanguagesCreate from '../components/admin/cruds/Languages/Create.vue'
import LanguagesShow from '../components/admin/cruds/Languages/Show.vue'
import LanguagesEdit from '../components/admin/cruds/Languages/Edit.vue'

import PrePageEdit from '../components/admin/cruds/Tests/Page/PrePageEdit.vue'
import PostPageEdit from '../components/admin/cruds/Tests/Page/PostPageEdit.vue'

import HomeView from '../components/admin/home/Home.vue'



Vue.use(VueRouter)

const routes = [

    { path: '/home', component: HomeView, name: 'admin.home' },
    { path: '/change-password', component: ChangePassword, name: 'auth.change_password' },
    { path: '/categories', component: CategoriesIndex, name: 'categories.index' },
    { path: '/categories/create', component: CategoriesCreate, name: 'categories.create' },
    { path: '/categories/:id', component: CategoriesShow, name: 'categories.show' },
    { path: '/categories/:id/edit', component: CategoriesEdit, name: 'categories.edit' },
    //{ path: '/tests', component: CategoriesIndexTileView, name: 'tests.index' },

    //************for test*******************/
    { path: '/category/tile', component: CategoriesIndexTileView, name: 'category.tile.index' },
    { path: '/category/:id/tests', component: TestsIndex, name: 'tests.index' },
    { path: '/category/:id/tests/create', component: TestsCreate, name: 'tests.create' },
    { path: '/tests/:id', component: TestsShow, name: 'tests.show' },
    { path: '/tests/:id/edit', component: TestsEdit, name: 'tests.edit' },

    //************for page*******************/
    { path: '/tests/:id/pre/edit', component: PrePageEdit, name: 'test.prepage.edit' },
    { path: '/tests/:id/post/edit', component: PostPageEdit, name: 'test.postpage.edit' },
    //***************************************/
    //*************for factor****************/
    { path: '/test/:id/factors', component: FactorsIndex, name: 'factors.index' },
    { path: '/test/:id/factors/create', component: FactorsCreate, name: 'factors.create' },
    { path: '/factors/:id', component: FactorsShow, name: 'factors.show' },
    { path: '/factors/:id/edit', component: FactorsEdit, name: 'factors.edit' },
    //*************for factor result**************/
    { path: '/factor/:id/results', component: FactorResultsIndex, name: 'factor.results.index' },
    { path: '/factor/:id/results/create', component: FactorResultsCreate, name: 'factor.results.create' },
    { path: '/factor-results/:id', component: FactorResultsShow, name: 'factor.results.show' },
    { path: '/factor-results/:id/edit', component: FactorResultsEdit, name: 'factor.results.edit' },
    //*************for question**************/
    { path: '/test/:id/questions/:type', component: QuestionsIndex, name: 'questions.index' },
    { path: '/test/:id/questions/create/:type', component: QuestionsCreate, name: 'questions.create', meta: 'QuestionsSingle' },
    { path: '/questions/:id', component: QuestionsShow, name: 'questions.show' },
    { path: '/questions/:id/edit', component: QuestionsEdit, name: 'questions.edit', meta: 'QuestionsSingle' },
    //*************for topic question**************/
    { path: '/topic/:id/topicQuestions', component: TopicQuestionsIndex, name: 'topic.questions.index' },
    { path: '/topic/:id/topicQuestions/create', component: TopicQuestionsCreate, name: 'topic.questions.create' },
    { path: '/topicQuestions/:id', component: TopicQuestionsShow, name: 'topic.questions.show' },
    { path: '/topicQuestions/:id/edit', component: TopicQuestionsEdit, name: 'topic.questions.edit' },
    //*************for key topic**************/
    { path: '/topics', component: TopicsIndex, name: 'topics.index' },
    { path: '/topics/create', component: TopicsCreate, name: 'topics.create', meta: 'TopicsSingle' },
    { path: '/topics/:id', component: TopicsShow, name: 'topics.show' },
    { path: '/topics/:id/edit', component: TopicsEdit, name: 'topics.edit', meta: 'TopicsSingle' },
    //*************for result**************/
    { path: '/test/:id/results', component: ResultsIndex, name: 'results.index' },
    { path: '/test/:id/results/create', component: ResultsCreate, name: 'results.create', meta: 'ResultsSingle' },
    { path: '/results/:id', component: ResultsShow, name: 'results.show' },
    { path: '/results/:id/edit', component: ResultsEdit, name: 'results.edit', meta: 'ResultsSingle' },

    //*************for answer**************/
    { path: '/question/:id/answers', component: AnswersIndex, name: 'answers.index' },
    { path: '/question/:id/answers/create', component: AnswersCreate, name: 'answers.create' },
    { path: '/answers/:id', component: AnswersShow, name: 'answers.show' },
    { path: '/answers/:id/edit', component: AnswersEdit, name: 'answers.edit' },

    //*************for language**************/
    { path: '/languages', component: LanguagesIndex, name: 'languages.index' },
    { path: '/languages/create', component: LanguagesCreate, name: 'languages.create' },
    { path: '/languages/:id', component: LanguagesShow, name: 'languages.show' },
    { path: '/languages/:id/edit', component: LanguagesEdit, name: 'languages.edit' },

    { path: '/permissions', component: PermissionsIndex, name: 'permissions.index' },
    { path: '/permissions/create', component: PermissionsCreate, name: 'permissions.create' },
    { path: '/permissions/:id', component: PermissionsShow, name: 'permissions.show' },
    { path: '/permissions/:id/edit', component: PermissionsEdit, name: 'permissions.edit' },
    { path: '/roles', component: RolesIndex, name: 'roles.index' },
    { path: '/roles/create', component: RolesCreate, name: 'roles.create' },
    { path: '/roles/:id', component: RolesShow, name: 'roles.show' },
    { path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit' },
    { path: '/users', component: UsersIndex, name: 'users.index' },
    { path: '/users/create', component: UsersCreate, name: 'users.create' },
    { path: '/users/:id', component: UsersShow, name: 'users.show' },
    { path: '/users/:id/edit', component: UsersEdit, name: 'users.edit' },
]

export default new VueRouter({
    mode: 'history',
    base: '/admin',
    routes
})