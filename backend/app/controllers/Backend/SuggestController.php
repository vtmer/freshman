<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Input;
use Redirect;
use Suggest as SuggestModel;
use Validator;

class SuggestController extends BaseController {

    /**
     * Backend Suggest index
     *
     * @return Response
     */
    public function showSuggest()
    {
        $suggests = array();
        $suggests = SuggestModel::orderBy('id','desc')->get();

        return View::make('Backend.Suggest.Suggest_part', array('page' => 'suggest',
            'suggests' => $suggests ));
    }

    /**
     * Backend Suggest delete
     *
     * @return Response
     */
    public function deleteSuggest()
    {
        $validator = Validator::make(Input::all(), array(
            'ids' => 'required'
        ));

        if($validator->fails()) {
            return Redirect::route('BackendShowSuggest')
                ->withInput()
                ->withErrors($validator);
        } else {
            $ids = Input::get('ids');
            foreach($ids as $id) {
                $suggest = SuggestModel::findOrFail($id);
                $suggest->delete();
            }

            return Redirect::route('BackendShowSuggest')
                ->with('success','反馈信息删除成功');
        }
    }
}
