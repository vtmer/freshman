<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Catagory as CatagoryModel;
use Validator;
use Input;
use Redirect;
use Article_catagory as ArticleCatagoryModel;

class CatagoryController extends BaseController {

    /**
     * Backend Catagory index
     *
     * @return Response
     */
    public function showCatagory(){

        /**
         * take the catagory information
         */
        $catagories = array();
        foreach(CatagoryModel::all() as $catagory){

            $articlenumber = ArticleCatagoryModel::where('catagory_id','=',$catagory['id'])->count();
            $catagories[] = array(
                            'id'=> $catagory['id'],
                            'catagory' => $catagory['catagory'],
                            'articlenumber' => $articlenumber,
                        );
        }

        return View::make('Backend.Catagory.Catagory_part',array('page' => 'catagory',
            'catagories' => $catagories));
    }

    /**
     * Backend New Catagory
     *
     * @return Redirect
     */
    public function newCatagory()
    {
        $validator = Validator::make(Input::all(),array(
            'catagory' => 'required|min:4|max:20'
        ));

        if($validator->fails()){
            return Redirect::route('BackendShowCatagory')
                ->withInput()
                ->withErrors($validator);
        }

        $catagory = Input::get('catagory');
        if (CatagoryModel::where('catagory','=',$catagory)->count() !== 0){

            return Redirect::route('BackendShowCatagory')
                    ->with(array(
                        'error' => "$catagory 已经存在，请选择其他名字"
                    ));
        }
        $catagory = new CatagoryModel(array('catagory'=>$catagory));
        $catagory->save();

        return Redirect::route('BackendShowCatagory')
            ->with('success','目录创建成功');
    }

    /**
     * Backend Update Catagory
     *
     * @return Redirect
     */
    public function updateCatagory()
    {
        $catagory = CatagoryModel::find(Input::get('id'));

        $validator = Validator::make(Input::all(),array(
                'catagory' => 'required|min:4|max:20'
            ));
        if($validator->fails()){
            return Redirect::route('BackendShowCatagory')
                ->withInput()
                ->withErrors($validator);
        }

        $catagory->catagory = Input::get('catagory');
        $catagory->save();

        return Redirect::route('BackendShowCatagory')
            ->with('success','栏目名修改成功');
    }

    /**
     * Backend delete catagory
     *
     * @return Redirect
     */
    public function deleteCatagory()
    {
        $catagory = CatagoryModel::find(Input::get('id'));

        $catagory->delete();

        $delete_article_catagory = ArticleCatagoryModel::where('catagory_id','=',$catagory->id)->delete();

        return Redirect::route('BackendShowCatagory')
            ->with('success','栏目删除成功');
    }
}
