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
                'title' => 'Admin',
                'description' => 'Admin Manager',
                'slug' => 'admin',
                'url' => 'ahmadsyamim/admin-module',
                'status' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Theme',
                'description' => 'Theme Manager',
                'slug' => 'theme',
                'url' => 'ahmadsyamim/theme-module',
                'status' => 0,
            ),
        ));
        
        
    }
}