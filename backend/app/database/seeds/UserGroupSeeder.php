<?php

class UserGroupSeeder extends Seeder{

    public function run()
    {
        DB::table('usergroup')->delete();

        Usergroup::create(array(
            'group_id' => '1',
            'user_id' => '1',
            'displayname' => 'root'
        ));
        Usergroup::create(array(
            'group_id' => '2',
            'user_id' => '1',
            'displayname' => 'root'
        ));
        Usergroup::create(array(
            'group_id' => '3',
            'user_id' => '1',
            'displayname' => 'root'
        ));



    }
}
