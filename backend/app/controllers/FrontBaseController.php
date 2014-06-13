<?php namespace Controllers;

use Controller;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use View;
use Cookie;
use Response;
use Redirect;
use Config;


class FrontBaseController extends Controller {

    /**
     * Front's HeaderNav information
     *
     * @var object
     */
    protected $catagories;
    protected $schoolParts;

    /**
     * schoolpart'id
     *
     * @var object
     */
    protected $schoolPartId;


    /**
     * FrontBaseController construct
     *
     * DO: get global catagorise and SchoolParts
     *     set the current SchoolPart according Cookie
     *
     * @return Null
     */
    public function __construct()
    {
        $this->catagories = CatagoryModel::all();
        $this->schoolParts = SchoolPartModel::all();

        if(!Cookie::get('PartId')) {
            $tmpSchoolPartId = Config::get('freshman.initSchoolPart');
            Cookie::queue('PartId', $tmpSchoolPartId);
            $this->schoolPartId = $tmpSchoolPartId;
        } else {
            $this->schoolPartId = Cookie::get('PartId');
        }

        //交换校区的位置，数组下标0为当前校区
        $tempSchoolPart = $this->schoolParts[0];
        $this->schoolParts[0] = $this->schoolParts[$this->schoolPartId - 1];
        $this->schoolParts[$this->schoolPartId - 1] = $tempSchoolPart;

        View::share(array(
            'catagories' => $this->catagories,
            'schoolParts' => $this->schoolParts,
            'schoolPartId' => $this->schoolPartId
        ));
    }

    /**
     * get the Catagory and relevant article
     *
     * @return Array
     */
    public function getCatagoryArticle()
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

        return $catagories;
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
