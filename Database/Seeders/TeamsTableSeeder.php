<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teams')->delete();
        
        \DB::table('teams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'name' => 'admin\'s Team',
                'personal_team' => 1,
                'created_at' => '2021-07-26 10:53:02',
                'updated_at' => '2021-07-26 10:53:02',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'name' => 'emp1\'s Team',
                'personal_team' => 1,
                'created_at' => '2021-07-26 10:53:02',
                'updated_at' => '2021-07-26 10:53:02',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 4,
                'name' => 'emp2\'s Team',
                'personal_team' => 1,
                'created_at' => '2021-07-26 10:53:02',
                'updated_at' => '2021-07-26 10:53:02',
            ),
        ));
        
        
    }
}