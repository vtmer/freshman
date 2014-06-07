<?php namespace Controllers;

use Controller;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use View;
use Cookie;
use Response;
use Redirect;


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

    public function __construct(){

        $this->catagories = CatagoryModel::all();
        $this->schoolParts = SchoolPartModel::all();

        if(!Cookie::get('PartId')) {
            Cookie::queue('PartId', '1');
            $this->schoolPartId = Cookie::get('PartId');
        } else {
            $this->schoolPartId = Cookie::get('PartId');
        }

        View::share(array(
            'catagories' => $this->catagories,
            'schoolParts' => $this->schoolParts,
            'schoolPartId' => $this->schoolPartId
        ));
    }

    public function __destruct()
    {
        $tempSchoolPart = $this->schoolParts[0];
        $this->schoolParts[0] = $this->schoolParts[$this->schoolPartId - 1];
        $this->schoolParts[$this->schoolPartId - 1] = $tempSchoolPart;
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
