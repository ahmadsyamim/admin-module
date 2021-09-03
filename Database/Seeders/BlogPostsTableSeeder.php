<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blog_posts')->delete();
        
        \DB::table('blog_posts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'author_id' => 0,
                'category_id' => 1,
                'title' => 'My First Blog Post',
                'seo_title' => NULL,
                'excerpt' => 'An example blog post',
                'body' => '<p>Matey yardarm topmast broadside nipper weigh anchor jack quarterdeck crow\'s nest rigging. Topgallant lateen sail line avast me gun Pirate Round strike colors bilge rat take a caulk. Jack six pounders spanker doubloon clipper spirits case shot hang the jib boatswain red ensign.</p>
<p>Hornswaggle spanker spyglass Yellow Jack mutiny Arr lugger poop deck keel take a caulk. Quarter fire ship run a shot across the bow sheet log draft scallywag gally port skysail. Lugsail gangway draft pink piracy bilge Buccaneer heave to landlubber or just lubber Pieces of Eight.</p>',
                'image' => NULL,
                'slug' => 'my-first-blog-post',
                'meta_description' => 'A test blog post',
                'status' => 'PUBLISHED',
                'featured' => 0,
                'created_at' => '2021-08-27 14:59:22',
                'updated_at' => '2021-08-27 14:59:22',
                'tags' => NULL,
                'published_date' => '2018-05-11 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'author_id' => 0,
                'category_id' => 1,
                'title' => 'My Second Blog Post',
                'seo_title' => NULL,
                'excerpt' => 'An example blog post',
                'body' => '<p>Matey yardarm topmast broadside nipper weigh anchor jack quarterdeck crow\'s nest rigging. Topgallant lateen sail line avast me gun Pirate Round strike colors bilge rat take a caulk. Jack six pounders spanker doubloon clipper spirits case shot hang the jib boatswain red ensign.</p>
<p>Hornswaggle spanker spyglass Yellow Jack mutiny Arr lugger poop deck keel take a caulk. Quarter fire ship run a shot across the bow sheet log draft scallywag gally port skysail. Lugsail gangway draft pink piracy bilge Buccaneer heave to landlubber or just lubber Pieces of Eight.</p>',
                'image' => NULL,
                'slug' => 'my-second-blog-post',
                'meta_description' => 'A test blog post',
                'status' => 'PUBLISHED',
                'featured' => 0,
                'created_at' => '2021-08-27 14:59:22',
                'updated_at' => '2021-08-27 14:59:22',
                'tags' => NULL,
                'published_date' => '2018-05-11 00:00:00',
            ),
        ));
        
        
    }
}