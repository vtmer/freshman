<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Article_schoolpart as ArticleSchoolPartModel;
use Cookie;
use Redirect;


class IndexController extends FrontBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * show Freshmen index
     *
     * @return Response
     */
	public function showIndex()
	{
        $catagories = $this->getCatagoryArticle();

        return View::make('Front/Index')->with(array(
            'catagoriesIndex' => $catagories,
            'newestInformation' => $catagories[$_ENV['NEWEST_INFORMATION_INDEX']]
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
