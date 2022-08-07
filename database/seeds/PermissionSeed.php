<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'user_management_access',],
            ['id' => 2, 'title' => 'permission_access',],
            ['id' => 3, 'title' => 'permission_create',],
            ['id' => 4, 'title' => 'permission_edit',],
            ['id' => 5, 'title' => 'permission_view',],
            ['id' => 6, 'title' => 'permission_delete',],
            ['id' => 7, 'title' => 'role_access',],
            ['id' => 8, 'title' => 'role_create',],
            ['id' => 9, 'title' => 'role_edit',],
            ['id' => 10, 'title' => 'role_view',],
            ['id' => 11, 'title' => 'role_delete',],
            ['id' => 12, 'title' => 'user_access',],
            ['id' => 13, 'title' => 'user_create',],
            ['id' => 14, 'title' => 'user_edit',],
            ['id' => 15, 'title' => 'user_view',],
            ['id' => 16, 'title' => 'user_delete',],
            ['id' => 18, 'title' => 'category_access',],
            ['id' => 19, 'title' => 'category_create',],
            ['id' => 20, 'title' => 'category_edit',],
            ['id' => 21, 'title' => 'category_view',],
            ['id' => 22, 'title' => 'category_delete',],
            ['id' => 24, 'title' => 'option_2_access',],
            ['id' => 25, 'title' => 'test_access',],
            ['id' => 26, 'title' => 'setting_access',],
            ['id' => 27, 'title' => 'option_1_access',],
            ['id' => 28, 'title' => 'test_access',],
            ['id' => 29, 'title' => 'test_create',],
            ['id' => 30, 'title' => 'test_edit',],
            ['id' => 31, 'title' => 'test_view',],
            ['id' => 32, 'title' => 'test_delete',],

            ['id' => 33, 'title' => 'question_access',],
            ['id' => 34, 'title' => 'question_create',],
            ['id' => 35, 'title' => 'question_edit',],
            ['id' => 36, 'title' => 'question_view',],
            ['id' => 37, 'title' => 'question_delete',],

            ['id' => 38, 'title' => 'answer_access',],
            ['id' => 39, 'title' => 'answer_create',],
            ['id' => 40, 'title' => 'answer_edit',],
            ['id' => 41, 'title' => 'answer_view',],
            ['id' => 42, 'title' => 'answer_delete',],

            ['id' => 43, 'title' => 'result_access',],
            ['id' => 44, 'title' => 'result_create',],
            ['id' => 45, 'title' => 'result_edit',],
            ['id' => 46, 'title' => 'result_view',],
            ['id' => 47, 'title' => 'result_delete',],
            
            ['id' => 48, 'title' => 'topic_access',],
            ['id' => 49, 'title' => 'topic_create',],
            ['id' => 50, 'title' => 'topic_edit',],
            ['id' => 51, 'title' => 'topic_view',],
            ['id' => 52, 'title' => 'topic_delete',],

                        
            ['id' => 53, 'title' => 'language_access',],
            ['id' => 54, 'title' => 'language_create',],
            ['id' => 55, 'title' => 'language_edit',],
            ['id' => 56, 'title' => 'language_view',],
            ['id' => 57, 'title' => 'language_delete',],

        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
