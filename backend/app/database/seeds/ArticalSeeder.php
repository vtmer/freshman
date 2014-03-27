<?php

class ArticalSeeder extends Seeder{

    public function run()
    {
        DB::table('artical')->delete();

        Artical::create(array(
            'title' => '测试文章一',
            'content'=> '这是测试文章一的内容哦～～～～～～～',
            'user' => 'root'
        ));

        Artical::create(array(
            'title' => '测试文章二',
            'content'=> '这是测试文章二的内容哦～～～～～～～',
            'user' => 'root'
        ));

        Artical::create(array(
            'title' => '测试文章三',
            'content'=> '这是测试文章三的内容哦～～～～～～～',
            'user' => 'root'
        ));

        Artical::create(array(
            'title' => '测试文章四',
            'content'=> '这是测试文章四的内容哦～～～～～～～',
            'user' => 'editor'
        ));

        Artical::create(array(
            'title' => '测试文章五',
            'content'=> '这是测试文章五的内容哦～～～～～～～',
            'user' => 'admin'
        ));
    }
}
