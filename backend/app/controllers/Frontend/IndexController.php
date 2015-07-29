<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Article_schoolpart as ArticleSchoolPartModel;
use Cookie;
use Redirect;
use Config;


class IndexController extends FrontBaseController {

    /**
     * show Freshmen index
     *
     * @return Response
     */
	public function showIndex()
	{
        $catagories = $this->getCatagoryArticle(Config::get('freshman.initShowArticleNumber'));

        if (!$this->isMobile())
            return View::make('Front/Index')->with(array(
                'catagoriesIndex' => $catagories,
                'headerChoose' => Config::get('freshman.chooseIndex'),
                'newestInformation' => $catagories[Config::get('freshman.newestInformationIndex')]
            ));
        else
            return View::make('mobile/Index')->with(array(
                'headerChoose' => Config::get('freshman.chooseIndex'),
                'newestInformation' => $catagories[Config::get('freshman.newestInformationIndex')]
            ));
	}

    /**
     * show Freshmen Index By SchoolPart Id
     *
     * @return Response
     */
    public function showIndexBySchoolPart($id)
    {
        $this->schoolPartId = $id;
        Cookie::queue('PartId',$this->schoolPartId);
        return Redirect::route('FrontendIndex');
    }

}
