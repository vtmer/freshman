<?php

class ActionSeeder extends Seeder{

    public function run()
    {
        DB::table('action')->delete();

        Action::create(array(
            'actionname' => '删除文章',
            'action' => 'deletearticle'
        ));

        Action::create(array(
            'actionname' => '查阅全部文章',
            'action' => 'seeallarticle'
        ));

        Action::create(array(
            'actionname' => '删除目录',
            'action' => 'deletecatagroy'
        ));

    }
}
