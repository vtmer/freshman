<?php namespace Models;

use Actiongroup as ActiongroupModel;
use Auth;

class Verification
{

    /**
     * User record
     *
     * @var object;
     */
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public  function Verification($action)
    {
        $is_allow = FALSE;

    	foreach($this->user->group as $group){
            $groupid = $group->id;
            if(ActiongroupModel::where('groupid','=',$groupid)
                        ->where('action','=',$action)->count() !== '0')
                        $is_allow = TRUE;
            if($is_allow){
                return $is_allow;
            }
        }

        return $is_allow;
    }
}

