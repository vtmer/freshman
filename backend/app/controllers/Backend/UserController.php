<?php namespace Controllers\Backend;

use View;
use Auth;
use Controllers\BaseController;
use Validator;
use Input;
use Redirect;
use App;
use User as UserModel;
use Article as ArticleModel;
use Usergroup as UsergroupModel;
use Hash;
/**
 * User controllers
 */
class UserController extends BaseController {

    /**
     * User login page
     *
     * @return \Rsponse
     */
    public function showLogin()
    {
        return View::make('Backend.User.Login');
    }

    /**
     * Handle user login request
     *
     * Input::all : 获取所有用户提交的信息
     * Input::only : 获取指定的信息
     * Validator类：用于验证数据以及获取错误消息
     * Auth::attempt : 用于用户验证
     *
     * @return \Redirect
     */
    public function doLogin()
    {
        $validator = Validator::make(Input::all(),array(
            'loginname' => 'required',
            'password' => 'required'
        ));

        if($validator->fails()){
            return Redirect::route('BackendLogin')
                ->withInput()
                ->withErrors($validator);
        }

        $input = Input::only('loginname','password');
        extract($input);

        if(Auth::attempt(array('loginname' => $loginname,'password' => $password))){

            if(Auth::user()->hasPermission('seeallarticle'))
                return Redirect::intended('/backend');
            else return Redirect::intended('/backend/article');
        }

        return Redirect::route('BackendLogin')
            ->with('error','用户名或密码错误');
    }

    /**
     * Logout User
     *
     * @return \Redirect
     */
    public function doLogout()
    {
        Auth::logout();

        return Redirect::route('FrontendShowIndex');
    }

    /**
     * Update User's information
     *
     * @return \Redirect
     */
    public function updateUser($id)
    {
        if($id !== Auth::user()->id){

            return App::abort(404);
        }
        $user = UserModel::findOrFail($id);

        $input = Input::only('originpassword','password','displayname');
        extract($input);

        if($originpassword == '' &&  $password == ''){

	         $validator = Validator::make(Input::all(),array(
           		 'displayname' => 'required|min:2|max:20',
                       	 ));
             if($validator->fails()){
             	 return Redirect::route('BackendShowArticle')
             	     ->withInput()
             	     ->withErrors($validator);
             }

             $user['displayname'] = $displayname;
             $user->save();

             return Redirect::route('BackendShowArticle')
                 ->with('success','用户名修改成功');
        }

        $validator = Validator::make(Input::all(),array(
                'displayname' => 'required|min:2|max:20',
                'password' => 'required|min:6|max:20'
            ));
        if($validator->fails()){
            return Redirect::route('BackendShowArticle')
                ->withInput()
                ->withErrors($validator);
        }

        if(!Hash::check($originpassword,$user['password']))
        {
            return Redirect::route('BackendShowArticle')
                ->withInput()
                ->with('error','原密码错误');
        }

        $user['password'] = Hash::make($password);
        $user['displayname'] = Input::get('displayname');
        $user->save();

        Auth::logout();

        return Redirect::route('BackendLogin')
            ->with('success','用户信息更新成功，请重新登录');

    }

    /**
     * Show all users
     *
     * @return Response
     */
    public function showUser()
    {
        /**
         *  take the user information
         */
        $users = array();
        foreach(UserModel::where('id','!=',Auth::user()->id)->get() as $user){

            $group = $user->groups;
            $articlenumber = ArticleModel::where('user_id','=',$user['id'])->count();
            $users[] = array(
                'id' => $user['id'],
                'loginname' => $user['loginname'],
                'displayname' => $user['displayname'],
                'created_at' => $user['created_at'],
                'permission' => $user['permission'],
                'articlenumber'=> $articlenumber,
                'group' => $group
            );
        }

        return View::make('Backend.User.User_part',array(
            'page' => 'user',
            'users' => $users,
            'newrootuser' => Auth::user()->hasPermission('newrootuser')));
    }

    /**
     * New user
     *
     * @return Redirect
     */
    public function newUsers()
    {
        $validator = Validator::make(Input::all(),array(
            'loginname' => 'required|min:2|max:20',
            'displayname' => 'required|min:2|max:15',
            'password' => 'required|min:6|max:20'
        ));

        if($validator->fails()){
            return Redirect::route('BackendShowUsers')
                ->withInput()
                ->withErrors($validator);
        }

        extract(Input::all());

        if(UserModel::where('loginname','=',$loginname)->count()!== 0){

            return Redirect::route('BackendShowUsers')
                ->with(array(
                    'error' => "$loginname 已经存在，请选择其他名字"
                ));
        }
        $user = new UserModel(array(
            'loginname' => $loginname,
            'displayname' => $displayname,
            'password' => Hash::make($password)
        ));
        $user->save();

        foreach($groups as $group){

            $usergroup = new UsergroupModel;
            $usergroup->user_id = $user->id;
            $usergroup->group_id = $group;
            $usergroup->displayname = $displayname;
            $usergroup->save();
        }


        return Redirect::route('BackendShowUsers')
            ->with('success','用户创建成功');
    }

    /**
     * Backend Remove Users
     *
     * @return \Redirect
     */
    public function removeUser($id)
    {
        $permission = Auth::user();
        if(!$permission->hasPermission('deleteuser') or $id==1){
            return Redirect::route('BackendShowUsers')
                ->with('error','权限不足');
        }
        $user = UserModel::findOrFail($id)->delete();
        $usergroup = UsergroupModel::where('user_id','=',$id)->delete();

        return Redirect::route('BackendShowUsers')
            ->with('success','成功删除用户');
    }
}
