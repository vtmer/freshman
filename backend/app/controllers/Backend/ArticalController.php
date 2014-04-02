<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Artical as ArticalModel;
use Action as ActionModel;
use Actiongroup as ActiongroupModel;
use Artical_catagory as Artical_catagoryModel;
use Redirect;
use Auth;
use App;
use Input;


class ArticalController extends BaseController {

    /**
     * Is allow to do?
     *
     * @var string
     *
     */
    protected $is_allow;

    /**
     * User record
     *
     * @var object
     */
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->is_allow = FALSE;
        $this->user = Auth::user();
    }

    /**
     * Backend Artical index
     *
     * @return Response
     */
    public function showArtical()
    {
        $action = 'seeallarticle';

        foreach($this->user->group as $group){
            $groupid = $group->id;
            if(ActiongroupModel::where('groupid','=',$groupid)
                        ->where('action','=',$action)->count() !== '0')
                        $this->is_allow = TRUE;
            if($this->is_allow) break;
        }


        if($this->is_allow){
            $post_artical = ArticalModel::all();
        }else{
            $post_artical = ArticalModel::where('user_id','=',Auth::user()->id)->get();
        }

        /**
         * take the information of artical
         */
        foreach($post_artical as $artical){

            $catagory = ArticalModel::find($artical['id'])->catagories->toArray();
            $articals[] = array(
                'id' => $artical['id'],
                'active' => $artical['active'],
                'title' => $artical['title'],
                'content'=> $artical['content'],
                'created_at' => $artical['created_at'],
                'see' => $artical['see'],
                'updown' => $artical['updown'],
                'user' => $artical['user'],
                'catagories' => $catagory
                );
        }
        return View::make('Backend.Artical.Artical_part',array('page'=> 'artical',
            'articals' => $articals));
    }

    /**
     * Backend Edit Artical
     *
     * @return Response
     */
    public function showEdit()
    {
        return View::make('Backend.Artical.Edit_artical',array('page'=>'artical'));
    }

    /**
     * Backend Show Update Artical
     *
     * @return Response
     */
    public function showUpdateArtical($id)
    {
        $artical = ArticalModel::findOrFail($id);
        $catagories = $artical->catagories->toArray();

        return View::make('Backend.Artical.Edit_artical',array('page'=>'artical',
                        'artical' => $artical,
                        'selected_catagories' => $catagories
                 ));

    }

    /**
     * Backend Updater Artical
     *
     * @return Redirect
     */
    public function updateArtical($id)
    {
        $artical = ArticalModel::findOrFail($id);

        extract(Input::all());

	    $artical->title = $title;
        $artical->content = $content;
        $artical->active = $active;
        $artical->updown = $updown;

        $artical->save();

        $delete_catagory = Artical_catagoryModel::where('artical_id','=',$id)->delete();
        foreach($catagories as $catagory){
            $artical_catagory = new Artical_catagoryModel;
            $artical_catagory->artical_id = $id;
            $artical_catagory->catagory_id = $catagory;
            $artical_catagory->save();
        }

        return Redirect::route('BackendShowArtical')
            ->with('success','文章修改成功');


    }

    /**
     * Backend Save Artical
     *
     * @return Redirect
     */
    public function saveEdit()
    {
        $artical = new ArticalModel;

        extract(Input::all());

        $artical->title = $title;
        $artical->content = $content;
        $artical->user_id = $this->user->id;
        $artical->user = $this->user->loginname;
        $artical->active = $active;
        $artical->updown = $updown;

        $artical->save();

        $articalid = $artical->id;
        foreach($catagories as $catagory){
            $artical_catagory = new Artical_catagoryModel;
            $artical_catagory->artical_id = $articalid;
            $artical_catagory->catagory_id = $catagory;
            $artical_catagory->save();
        }

        return Redirect::route('BackendShowArtical')
            ->with('success','文章保存成功');
    }

    /**
     * Backend Remove Artical
     *
     * @return Redirect
     */
    public function removeArtical($id)
    {
        if(Auth::user()->permission === '作者'){
            if(ArticalModel::findOrFail($id)->user_id != Auth::user()->id){
                return App::abort(404);
            }
        }
        $artical_catagory = ArticalModel::findOrFail($id)->artical_catagory();
        $artical_catagory->delete();
        $artical = ArticalModel::findOrFail($id);
        $artical->delete();
        return Redirect::route('BackendShowArtical')
            ->with('success','文章删除成功');
    }

    /**
     * Backend Updown change Artical
     *
     * @return Redirect
     */
    public function upDown($id)
    {
        $updown = ArticalModel::findOrFail($id);

        if($updown->updown == '0'){
             $updown['updown'] = '1';
            $message = '文章置顶成功';
        }else{
            $updown['updown'] ='0';
            $message = '文章取消置顶成功';
        }
        $updown->save();

        return Redirect::route('BackendShowArtical')
            ->with('success',$message);
    }

    /**
     * Backend Active change Artical
     *
     * @return Redirect
     */
    public function updateActive($id)
    {
        $active = ArticalModel::findOrFail($id);

        if($active->active == '0'){
            $active['active'] = '1';
            $message = '文章发布成功';
        }else{
            $active['active'] = '0';
            $message = '文章状态为草稿，未发布';
        }
        $active->save();

        return Redirect::route('BackendShowArtical')
            ->with('success',$message);
    }


}
