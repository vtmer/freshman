<?php

class UserSeeder extends Seeder{

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'loginname' => 'root',
            'displayname' => 'root',
            'password' => Hash::make('20130608q'),
        ));

        User::create(array(
            'loginname' => 'admin',
            'displayname' => 'admin',
            'password' => Hash::make('20130608q'),
        ));

        User::create(array(
            'loginname' => 'editor',
            'displayname' => 'editor',
            'password' => Hash::make('20130608q'),
        ));
    }
}
