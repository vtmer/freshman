<?php

class ActionSeeder extends Seeder{

    public function run()
    {
        DB::table('action')->delete();

        Action::create(array(
            'actionname' => '删除全部文章',
            'action' => 'deleteallarticle'
        ));

        Action::create(array(
            'actionname' => '查阅全部文章',
            'action' => 'seeallarticle'
        ));

        Action::create(array(
            'actionname' => '删除用户',
            'action' => 'deleteuser'
        ));
        Action::create(array(
            'actionname' => '查看全部页面',
            'action' => 'seeallpages'
        ));
        Action::create(array(
            'actionname' => '新建超级管理员',
            'action' => 'newrootuser'
        ));


    }
}
