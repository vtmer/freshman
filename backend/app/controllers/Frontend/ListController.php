<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;

class ListController extends FrontBaseController {

    /**
     * Frontend's list Page
     *
     * @return response
     */
    public function showList($id)
    {
        $catagories = $this->getCatagoryArticle();
        $getCatagory = $this->paginate($id);

        return View::make('Front/List')->with(array(
            'getCatagory' => $getCatagory,
            'catagoriesList' => $catagories,
            'chooseCatagoryId' => $id
        ));
    }

    //分页:调用对应数据
    public function paginate($id)
    {
        $articleNumber = $_ENV['ARTICLE_NUMBER'];
        $schoolPart = SchoolPartModel::find($this->schoolPartId);
        $catagory = CatagoryModel::find($id);
        $catagory['articles'] = CatagoryModel::find($catagory['id'])
                ->articles()
                ->join('article_schoolpart','article.id','=','article_schoolpart.article_id')
                ->orderBy('updown','desc')
                ->orderBy('id','desc')
                ->where('active','=',1)
                ->where('schoolpart_id','=',$schoolPart['id'])
                ->paginate($articleNumber);
        return $catagory;
    }
}

