<?php namespace Controllers;

use Controller;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use View;

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
        $this->schoolPartId = 1;

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
