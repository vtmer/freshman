<?php

class Actiongroup extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'actiongroup';

    /**
     * the attribute that allow to set value together
     *
     * @var array
     */
    protected $fillable = array('action','group_id');

   /**
     * @var string
     *
     * not allow laravel change the created_at time
     * and updated_at time
     */
    public $timestamps = false;
}
