<?php

class Article_schoolpart extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'article_schoolpart';

    /**
     * the attribute that allow to set value together
     *
     * @var array
     */
    protected $fillable = array('article_id','schoolpart_id');

    /**
     * @var string;
     *
     */
    public $timestamps = false;
}
