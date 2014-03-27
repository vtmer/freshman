<?php namespace Frontend;

use Controller;
use View;


class HomeController extends Controller {

    /**
     * Freshmen index
     *
     * @return Response
     */
	public function showindex()
	{
		return View::make('hello');
	}

}
