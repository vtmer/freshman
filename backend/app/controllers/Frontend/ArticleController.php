<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Article as ArticleModel;
use Article_catagory as ArticleCatagoryModel;

class ArticleController extends FrontBaseController {

    /**
     * Frontend's Article Page
     *
     * @return response
     */
    public function showArticle($catagory,$id)
    {
        $catagories = $this->getCatagoryArticle();
        $article = ArticleModel::where('active','=',1)->findOrFail($id);
        $currentCatagory = CatagoryModel::find($catagory);

        $this->increaseViewNumber($id);

        return View::make('Front/Content')->with(array(
            'catagoriesList' => $catagories,
            'currentCatagory' => $currentCatagory,
            'chooseCatagoryId' => $_ENV['NULL_CHOOSE_CATAGORY_ID'],
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

