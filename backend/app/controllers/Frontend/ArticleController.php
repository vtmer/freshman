<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Article as ArticleModel;
use Article_catagory as ArticleCatagoryModel;
use Config;

class ArticleController extends FrontBaseController {

    /**
     * Frontend's Article Page
     *
     * @return response
     */
    public function showArticle($catagory,$id)
    {
        $catagories = $this->getCatagoryArticle(Config::get('freshman.initShowAricleNumber'));
        $article = ArticleModel::where('active','=',1)->findOrFail($id);
        $currentCatagory = CatagoryModel::find($catagory);

        $this->increaseViewNumber($id);

        return View::make('Front/Content')->with(array(
            'catagoriesList' => $catagories,
            'currentCatagory' => $currentCatagory,
            'chooseCatagoryId' => Config::get('freshman.nullChooseCatagoryId'),
            'headerChooseCatagoryId' => $catagory,
            'article' => $article
        ));
    }

    /**
     * Add a see
     *
     * @return null
     */
    public function increaseViewNumber($id)
    {
        $see = ArticleModel::findOrFail($id);

        $see['see'] += 1;
        $see->save();
    }
}

