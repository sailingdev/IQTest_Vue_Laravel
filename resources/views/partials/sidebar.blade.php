@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i>
                    <span>@lang('quickadmin.qa_dashboard')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <router-link :to="{ name: 'admin.home' }">

                            <span class="title">@lang('quickadmin.qa_dashboard')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('category_access')">
                <a href="#">
                    <i class="fa fa-sitemap"></i>
                    <span>@lang('quickadmin.category.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('category_access')">
                        <router-link :to="{ name: 'categories.index' }">
                            <i class="fa fa-sitemap"></i>
                            <span>@lang('quickadmin.category.caption')</span>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li class="treeview" v-if="$can('test_access')">
                <a href="#">
                    <i class="fa fa-question-circle-o"></i>
                    <span>@lang('quickadmin.test.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('test_access')">
                        <router-link :to="{ name: 'category.tile.index' }">
                            <i class="fa fa-question-circle-o"></i>
                            <span>@lang('quickadmin.test.caption')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('topic_access')">
                <a href="#">
                    <i class="fa fa-sitemap"></i>
                    <span>Key Topic</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('topic_access')">
                        <router-link :to="{ name: 'topics.index' }">
                            <i class="fa fa-sitemap"></i>
                            <span>Key Topic</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('user_management_access')">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('permission_access')">
                        <router-link :to="{ name: 'permissions.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.permissions.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('role_access')">
                        <router-link :to="{ name: 'roles.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.roles.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('user_access')">
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fa fa-user"></i>
                            <span>@lang('quickadmin.users.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('setting_access')">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>@lang('quickadmin.setting.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li v-if="$can('language_access')">
                        <router-link :to="{ name: 'languages.index' }">
                            <i class="fa fa-adn"></i>
                            <span>@lang('quickadmin.language.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li>
                <router-link :to="{ name: 'auth.change_password' }">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                </router-link>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>