<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use Input;
use Redirect;
use Suggest as SuggestModel;
use Validator;

class SuggestController extends FrontBaseController {

    /**
     * Frontend new Suggest
     *
     * @return Redirect
     */
    public function newSuggest()
    {
        extract(Input::all());

        $user = new SuggestModel(array(
            'name' => $name,
            'email' => $email,
            'suggest' => $suggest
        ));

        $user->save();

        return Redirect::back()->with('thank','感谢您的建议反馈，我们将做得更好');

    }

}
