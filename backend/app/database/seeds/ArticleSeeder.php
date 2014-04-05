<?php

class ArticleSeeder extends Seeder{

    public function run()
    {
        DB::table('article')->delete();

        Article::create(array(
            'title' => '测试文章一',
            'content'=> '这是测试文章一的内容哦～～～～～～～',
            'user_id' => 1,
            'user' => 'root'
        ));

        Article::create(array(
            'title' => '测试文章二',
            'content'=> '这是测试文章二的内容哦～～～～～～～',
            'user_id' => '1',
            'user' => 'root'
        ));

        Article::create(array(
            'title' => '测试文章三',
            'content'=> '这是测试文章三的内容哦～～～～～～～',
            'user_id' => '1',
            'user' => 'root'
        ));

        Article::create(array(
            'title' => '测试文章四',
            'content'=> '这是测试文章四的内容哦～～～～～～～',
            'user_id'=> '3',
            'user' => 'editor'
        ));

        Article::create(array(
            'title' => '测试文章五',
            'content'=> '这是测试文章五的内容哦～～～～～～～',
            'user_id' => '2',
            'user' => 'admin'
        ));
    }
}
