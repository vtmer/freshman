<?php

class UserSeeder extends Seeder{

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'loginname' => 'root',
            'displayname' => 'root',
            'password' => Hash::make('xinshengwang'),
        ));

    }
}
