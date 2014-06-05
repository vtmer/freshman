<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use View;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use Article_schoolpart as ArticleSchoolPartModel;


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
        $schoolPart = SchoolPartModel::find($this->schoolPartId);
        foreach(CatagoryModel::all() as $catagory) {
            $catagory['articles'] = CatagoryModel::find($catagory['id'])
                ->articles()
                ->join('article_schoolpart','article.id','=','article_schoolpart.article_id')
                ->orderBy('updown','desc')
                ->orderBy('id','desc')
                ->where('active','=',1)
                ->where('schoolpart_id','=',$schoolPart['id'])
                ->get();
            $catagories[] = $catagory;
        }
        return View::make('Front/Index')->with(array(
            'catagoriesIndex' => $catagories
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
        return $this->showIndex();
    }

}
