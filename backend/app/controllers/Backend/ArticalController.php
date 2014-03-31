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
    public function showartical()
    {
        if(Auth::user()->permission == '作者'){
            $post_artical = ArticalModel::where('user','=',Auth::user()->displayname)->get();
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
    public function showedit()
    {
        return View::make('Backend.Artical.Edit_artical',array('page'=>'artical'));
    }

    /**
     * Backend Save Artical
     *
     * @return Redirect
     */
    public function saveedit()
    {
    }

    /**
     * Backend Remove Artical
     *
     * @return Redirect
     */
    public function removeartical($id)
    {
        if(Auth::user()->permission == '作者'){
            if(ArticalModel::findOrFail($id)->user !== Auth::user()->displayname){
                return App::abort(404);
            }
        }
        $post = ArticalModel::findOrFail($id);
        $post->delete();
        $post = ArticalModel::findOrFail($id)->artical_catagory();
        $post->delete();

        return Redirect::route('BackendShowArtical')
            ->with('success','文章删除成功');
    }
}
