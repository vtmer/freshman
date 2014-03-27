<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;

class HomeController extends BaseController {

    /**
     * Backend Artical index
     *
     * @return Response
     */
    public function showIndex(){
        return View::make('Backend.Index');
    }
}
