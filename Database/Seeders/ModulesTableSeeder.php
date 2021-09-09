<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modules')->delete();
        
        \DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Theme',
                'description' => 'Theme Manager',
                'slug' => 'theme',
                'url' => NULL,
                'status' => 0,
            ),
        ));
        
        
    }
}