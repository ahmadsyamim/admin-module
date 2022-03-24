<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-07-28 20:50:38',
                'updated_at' => '2021-07-28 20:50:38',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-07-28 20:50:38',
                'updated_at' => '2021-07-28 20:50:38',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-07-28 20:50:38',
                'updated_at' => '2021-07-28 20:50:38',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'blog_posts',
                'slug' => 'blog_posts',
                'display_name_singular' => 'Blog Post',
                'display_name_plural' => 'Blog Posts',
                'icon' => 'voyager-news',
                'model_name' => 'Pvtl\\VoyagerFrontend\\BlogPost',
                'policy_name' => NULL,
                'controller' => '\\Pvtl\\VoyagerFrontend\\Http\\Controllers\\PostController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2021-07-30 14:08:20',
                'updated_at' => '2021-09-03 13:21:58',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => 'Category',
                'display_name_plural' => 'Categories',
                'icon' => 'voyager-categories',
                'model_name' => 'Pvtl\\VoyagerBlog\\Category',
                'policy_name' => NULL,
                'controller' => '\\TCG\\Voyager\\Http\\Controllers\\VoyagerBaseController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2021-07-30 14:08:21',
                'updated_at' => '2021-09-03 13:22:10',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'pages',
                'slug' => 'pages',
                'display_name_singular' => 'Page',
                'display_name_plural' => 'Pages',
                'icon' => 'voyager-file-text',
                'model_name' => 'Pvtl\\VoyagerFrontend\\Page',
                'policy_name' => NULL,
                'controller' => '\\Pvtl\\VoyagerFrontend\\Http\\Controllers\\PageController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-07-30 14:08:33',
                'updated_at' => '2021-08-27 14:59:28',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'modules',
                'slug' => 'modules',
                'display_name_singular' => 'Module',
                'display_name_plural' => 'Modules',
                'icon' => NULL,
                'model_name' => 'Modules\\Admin\\Entities\\Module',
                'policy_name' => NULL,
                'controller' => 'Modules\\Admin\\Http\\Controllers\\ModuleController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2021-09-03 22:21:19',
                'updated_at' => '2021-09-03 22:24:48',
            ),
        ));
        
        
    }
}