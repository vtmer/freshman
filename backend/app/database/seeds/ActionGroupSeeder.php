<?php

class ActionGroupSeeder extends Seeder{

    public function run()
    {
        DB::table('actiongroup')->delete();

        Actiongroup::create(array(
            'groupid' => '1',
            'actionid' => '1'
        ));
        Actiongroup::create(array(
            'groupid' => '1',
            'actionid' => '2'
        ));
        Actiongroup::create(array(
            'groupid' => '1',
            'actionid' => '3'
        ));
        Actiongroup::create(array(
            'groupid' => '1',
            'actionid' => '4'
        ));
        Actiongroup::create(array(
            'groupid' => '1',
            'actionid' => '5'
        ));
        Actiongroup::create(array(
            'groupid' => '2',
            'actionid' => '1'
        ));
        Actiongroup::create(array(
            'groupid' => '2',
            'actionid' => '2'
        ));
        Actiongroup::create(array(
            'groupid' => '2',
            'actionid' => '3'
        ));
        Actiongroup::create(array(
            'groupid' => '2',
            'actionid' => '4'
        ));
        Actiongroup::create(array(
            'groupid' => '3',
            'actionid' => '1'
        ));


    }
}
