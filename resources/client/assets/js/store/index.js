import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import ChangePassword from './modules/change_password'
import Rules from './modules/rules'
import CategoriesIndex from './modules/Categories'
import CategoriesSingle from './modules/Categories/single'
import PermissionsIndex from './modules/Permissions'
import PermissionsSingle from './modules/Permissions/single'
import RolesIndex from './modules/Roles'
import RolesSingle from './modules/Roles/single'
import UsersIndex from './modules/Users'
import UsersSingle from './modules/Users/single'
import TestsIndex from './modules/Tests'
import TestsSingle from './modules/Tests/single'
import TestsPageSingle from './modules/Tests/page'
import FactorsIndex from './modules/Factors'
import FactorsSingle from './modules/Factors/single'
import FactorResultsIndex from './modules/FactorResults'
import FactorResultsSingle from './modules/FactorResults/single'
import QuestionsIndex from './modules/Questions'
import QuestionsSingle from './modules/Questions/single'
import TopicsIndex from './modules/Topics'
import TopicsSingle from './modules/Topics/single'
import TopicQuestionsIndex from './modules/TopicQuestions'
import TopicQuestionsSingle from './modules/TopicQuestions/single'
import ResultsIndex from './modules/Results'
import ResultsSingle from './modules/Results/single'
import AnswersIndex from './modules/Answers'
import AnswersSingle from './modules/Answers/single'
import ImageFileInput from './modules/image_file_input'
import LanguagesIndex from './modules/Languages'
import LanguagesSingle from './modules/Languages/single'



Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Alert,
        ChangePassword,
        Rules,
        CategoriesIndex,
        CategoriesSingle,
        PermissionsIndex,
        PermissionsSingle,
        RolesIndex,
        RolesSingle,
        UsersIndex,
        UsersSingle,
        TestsIndex,
        TestsSingle,
        FactorsIndex,
        FactorsSingle,
        FactorResultsIndex,
        FactorResultsSingle,
        QuestionsIndex,
        QuestionsSingle,
        ResultsIndex,
        ResultsSingle,
        AnswersIndex,
        AnswersSingle,
        TopicsIndex,
        TopicsSingle,
        ImageFileInput,
        LanguagesIndex,
        LanguagesSingle,
        TopicQuestionsIndex,
        TopicQuestionsSingle,
        TestsPageSingle
    },
    strict: debug,
})