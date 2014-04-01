<?php

class Usergroup extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'usergroup';

    /**
     * the attribute that allow to set value together
     *
     * @var array
     */
    protected $fillable = array('group_id','user_id','displayname');
}
