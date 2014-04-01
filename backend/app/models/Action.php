<?php
class Action extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'action';

    /**
     * the attribute that allow to make a value together
     */
    protected $fillable = array('actionname','action');

    /**
     * @var string
     *
     * not allow laravel change the created_at time
     * and updated_at time
     */
    public $timestamps = false;

    /**
     * User fields declaration
     *
     * @return object
     */
    public function group()
    {
        return $this->belongsToMany('Group','actiongroup',
            'action','group_id');
    }
}
