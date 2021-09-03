<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'name' => 'admin',
                'email' => 'ahmad.syamim@gmail.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$5OmZ1Tog.6au5wfU28zqZuPKYjKNsr8wyEX2ormcjw.yxn.bOvLMW',
                'remember_token' => NULL,
                'settings' => NULL,
                'created_at' => '2021-08-27 13:44:32',
                'updated_at' => '2021-08-27 13:44:32',
            ),
        ));
        
        
    }
}