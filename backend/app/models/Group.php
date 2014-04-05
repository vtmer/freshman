<?php
class Group extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'group';

    /**
     * the attribute that allow to make a value together
     */
    protected $fillable = array('groupname');

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
    public function users()
    {
        return $this->belongsToMany('User','usergroup','group_id','user_id');
    }

    /**
     * Action fields declaration
     *
     * @return object
     */
    public function action()
    {
        return $this->belongsToMany('Action','actiongroup',
                    'groupid','action');

    }
}
