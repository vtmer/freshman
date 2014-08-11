<?php

class Suggest extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'suggest';

    protected $fillable = array('id', 'name', 'email', 'suggest');

}
