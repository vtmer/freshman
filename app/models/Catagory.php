<?php

class Catagory extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'catagory';

    /**
     * @var string
     *
     * not allow laravel change the create_up time
     * and update_up time
     */
    public $timestamps = false;

    protected $fillable = array('id','catagory');
}
