<?php

class GroupSeeder extends Seeder{

    public function run()
    {
        DB::table('group')->delete();

        Group::create(array(
            'groupname' => '超级管理员'
        ));

        Group::create(array(
            'groupname' => '管理员'
        ));

        Group::create(array(
            'groupname' => '作者'
        ));

    }
}
