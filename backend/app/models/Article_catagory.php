<?php

class Article_catagory extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'article_catagory';

    /**
     * the attribute that allow to set value together
     *
     * @var array
     */
    protected $fillable = array('article_id','catagory_id');

    /**
     * @var string;
     *
     */
    public $timestamps = false;
}
