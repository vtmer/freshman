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
    public function actions()
    {
        return $this->belongsToMany('Action','actiongroup',
                    'groupid','action');

    }

    /**
     * Check whether the user has specific permission
     *
     * @return boolean
     */
    public function hasPermission($perm)
    {
        foreach($this->actions as $action){
            if($action->action === $perm){
                return true;
            }
        }
        return false;
    }
}
