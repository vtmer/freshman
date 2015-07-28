<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Config;
use strFilter;
use Response;

class ListController extends FrontBaseController {

    /**
     * Frontend's list Page
     *
     * @return response
     */
    public function showList($id)
    {
        $catagories = $this->getCatagoryArticle(Config::get('freshman.initShowArticleNumber'));
        $getCatagory = $this->paginate($id);

        if (!$this->isMobile())
            return View::make('Front/List')->with(array(
                'getCatagory' => $getCatagory,
                'catagoriesList' => $catagories,
                'headerChoose' => $id,
                'chooseCatagoryId' => $id
            ));
        else
            return View::make('mobile/List')->with(array(
                'getCatagory' => $getCatagory,
                'headerChoose' => $id
            ));
    }

    public function ajaxPaginate($id)
    {
        $getCatagory = $this->paginate($id);
        $data = array();
        foreach ($getCatagory['articles'] as $key => $article) {
            $data[$key]['cid'] = $getCatagory['id'];
            $data[$key]['id'] = $article['id'];
            $data[$key]['title'] = $article['title'];
            $data[$key]['desc'] = strFilter::filterHtmlLimit($article['content'],
                Config::get('freshman.substrLength'));
            $data[$key]['source'] = $article['source'];
            $data[$key]['created_at'] = $article['created_at'];
        }

        return Response::json(array('data' => $data));
    }

    public function paginate($id)
    {
        $articleNumber = Config::get('freshman.articleNumber');
        $schoolPart = SchoolPartModel::find($this->schoolPartId);
        $catagory = CatagoryModel::find($id);
        $catagory['articles'] = CatagoryModel::find($catagory['id'])
                ->articles()
                ->join('article_schoolpart','article.id','=','article_schoolpart.article_id')
                ->orderBy('updown','desc')
                ->orderBy('id','desc')
                ->where('active','=',1)
                ->where('schoolpart_id','=',$schoolPart['id'])
                ->paginate(3);
        return $catagory;
    }
}

