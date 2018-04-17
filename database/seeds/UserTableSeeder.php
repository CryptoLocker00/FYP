<?php

use App\Model\Role;
use App\Model\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id'   => '1',
            'name' => 'Administrator'
        ]);

        User::create(array(
            'email' => 'jason@greenroom.com.my',
            'name' => 'Jason Seah',
            'password' => '111111',
            'role_id' => '1'
        ));
    }
}
