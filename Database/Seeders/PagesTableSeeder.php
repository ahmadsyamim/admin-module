<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'author_id' => 0,
                'title' => 'Home',
                'excerpt' => 'This is the excerpt for the Lorem Ipsum Page',
                'body' => '<p><br /></p><h3 class="text-center">This is the body of the lorem ipsum page</h3><p class="text-center">This is the body of the lorem ipsum page</p><p><br /></p>',
                'image' => 'pages/page1.jpg',
                'slug' => 'home',
                'meta_description' => 'This is the meta description',
                'status' => 'ACTIVE',
                'created_at' => '2021-08-27 14:59:28',
                'updated_at' => '2021-08-27 14:59:28',
                'layout' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'author_id' => 0,
                'title' => 'About',
                'excerpt' => 'This is the excerpt for the Lorem Ipsum Page',
                'body' => '<p><br /></p><h3 class="text-center">This is the body of the lorem ipsum page</h3><p class="text-center">This is the body of the lorem ipsum page</p><p><br /></p>',
                'image' => 'posts/post2.jpg',
                'slug' => 'about',
                'meta_description' => 'This is the meta description for about',
                'status' => 'ACTIVE',
                'created_at' => '2021-08-27 14:59:28',
                'updated_at' => '2021-08-27 14:59:28',
                'layout' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'author_id' => 0,
                'title' => 'Contact',
                'excerpt' => 'This is the excerpt for the Lorem Ipsum Page',
                'body' => '<p><br /></p><h3 class="text-center">This is the body of the lorem ipsum page</h3><p class="text-center">This is the body of the lorem ipsum page</p><p><br /></p>',
                'image' => 'posts/post2.jpg',
                'slug' => 'contact',
                'meta_description' => 'This is the meta description for contact',
                'status' => 'ACTIVE',
                'created_at' => '2021-08-27 14:59:28',
                'updated_at' => '2021-08-27 14:59:28',
                'layout' => NULL,
            ),
        ));
        
        
    }
}