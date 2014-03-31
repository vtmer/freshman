<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Artical as ArticalModel;
use Redirect;
use Auth;
use App;


class ArticalController extends BaseController {

    /**
     * Backend Artical index
     *
     * @return Response
     */
    public function showArtical()
    {
        if(Auth::user()->permission === '作者'){
            $post_artical = ArticalModel::where('user_id','=',Auth::user()->id)->get();
        }else{
            $post_artical = ArticalModel::all();
        }
        /**
         * take the information of artical
         */
        foreach($post_artical as $artical){

            $catagory = ArticalModel::find($artical['id'])->catagories->toArray();
            $articals[] = array(
                'id' => $artical['id'],
                'title' => $artical['title'],
                'content'=> $artical['content'],
                'created_at' => $artical['created_at'],
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
     * Backend Save Artical
     *
     * @return Redirect
     */
    public function saveEdit()
    {
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
}
