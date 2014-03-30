<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Artical as ArticalModel;

class ArticalController extends BaseController {

    /**
     * Backend Artical index
     *
     * @return Response
     */
    public function showartical()
    {
        /**
         * take the information of artical
         */
        foreach(ArticalModel::all() as $artical){

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

    }
}
