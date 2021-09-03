<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2021-07-30 12:35:14',
                'updated_at' => '2021-07-30 12:35:14',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'primary',
                'created_at' => '2021-07-30 14:08:21',
                'updated_at' => '2021-07-30 14:08:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'social',
                'created_at' => '2021-07-30 14:08:33',
                'updated_at' => '2021-07-30 14:08:33',
            ),
        ));
        
        
    }
}