import Vue from 'vue'
import VueRouter from 'vue-router'
import UserHomeView from '../components/user/HomePage.vue'
import AllTestsView from '../components/user/AllTestsPage.vue'
import CategoryView from '../components/user/CategoryPage.vue'
import TestDetailView from '../components/user/TestDetailPage.vue'
import TestPreView from '../components/user/TestPrePage.vue'
import TestPostView from '../components/user/TestPostPage.vue'
import TestMainView from '../components/user/TestMainPage.vue'
import ResultView from '../components/user/TestResultPage.vue'
import OrderView from '../components/user/OrderPage.vue'
import LoadView from '../components/user/PreLoadPage.vue'
import TestFinishView from '../components/user/TestFinishedPage.vue'
import PaymentView from '../components/user/PaymentPage.vue'

Vue.use(VueRouter)

const routes = [

    //********************user page*************
    { path: '/home', component: UserHomeView, name: 'user.home' },
    { path: '/home/all-tests', component: AllTestsView, name: 'user.alltests' },
    { path: '/home/category/:id/tests', component: CategoryView, name: 'user.category' },
    { path: '/home/test/:id/detail', component: TestDetailView, name: 'user.test.detail' },
    { path: '/main/test/:id/load', component: LoadView, name: 'user.test.load' },
    { path: '/main/test/:id/pre', component: TestPreView, name: 'user.test.pre' },
    { path: '/main/test/:id/main', component: TestMainView, name: 'user.test.main' },
    { path: '/main/test/:id/post', component: TestPostView, name: 'user.test.post' },
    { path: '/main/:token/order', component: OrderView, name: 'user.test.order' },
    { path: '/main/:token/payment', component: PaymentView, name: 'user.test.payment' },
    { path: '/main/test/:id/finished', component: TestFinishView, name: 'user.test.finish' },
    { path: '/main/:token/result', component: ResultView, name: 'user.test.result' },
    //******************************************
];
export default new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    mode: 'history',
    base: '/user',
    routes
})