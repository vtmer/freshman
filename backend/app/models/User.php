<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    /**
     * the date that allow to attributes all
     *
     * @var string
     */
    protected $fillable = array('loginname','displayname','password','permission');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    /**
     * check whether the user has specific permission
     *
     * @return boolean
     */
    public function hasPermission($perm)
    {
        foreach($this->groups as $group){
            if($group->hasPermission($perm)){
                return true;
            }
        }

        return false;
    }

    /**
     * Group fileds delcation
     *
     * @return object
     */
    public function groups()
    {
        return $this->belongsToMany('Group','usergroup',
            'user_id','group_id');
    }
}
