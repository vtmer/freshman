<?php namespace Controllers\Backend;

use View;
use Controllers\BaseController;
use Article as ArticleModel;
use Action as ActionModel;
use Actiongroup as ActiongroupModel;
use Article_catagory as Article_catagoryModel;
use Article_schoolpart as Article_schoolpartModel;
use Models\Verification;
use Redirect;
use Auth;
use App;
use Input;


class ArticleController extends BaseController {

    /**
     * For user's information
     *
     * @var object
     */
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = Auth::user();
    }

    /**
     * Backend Article index
     *
     * @return Response
     */
    public function showArticle()
    {
        if($this->user->hasPermission('seeallarticle')){
            $post_article = ArticleModel::orderBy('active','desc')->orderBy('see')->get();
        }else{
            $post_article = ArticleModel::where('user_id','=',$this->user->id)->orderBy('active','desc')->orderBy('see')->get();
        }

        //init $articles
        $articles = array();

        // take the information of article
        foreach($post_article as $article){

            $articleid = ArticleModel::find($article['id']);
            $catagory = $articleid->catagories()->get();
            $schoolparts = $articleid->schoolparts()->get();
            $articles[] = array(
                'id' => $article['id'],
                'active' => $article['active'],
                'title' => $article['title'],
                'content'=> $article['content'],
                'created_at' => $article['created_at'],
                'see' => $article['see'],
                'updown' => $article['updown'],
                'user' => $article['user'],
                'catagories' => $catagory,
                'schoolparts' => $schoolparts
                );
        }

        return View::make('Backend.Article.Article_part',array('page'=> 'article',
            'articles' => $articles));
    }

    /**
     * Backend Edit Article
     *
     * @return Response
     */
    public function showEdit()
    {
        return View::make('Backend.Article.Edit_article',array('page'=>'article'));
    }

    /**
     * Backend Show Update Article
     *
     * @return Response
     */
    public function showUpdateArticle($id)
    {
        $article = ArticleModel::findOrFail($id);
        $catagories = $article->catagories->toArray();
        $schoolparts = $article->schoolparts->toArray();

        return View::make('Backend.Article.Edit_article',array('page'=>'article',
                        'article' => $article,
                        'selected_catagories' => $catagories,
                        'selected_schoolparts' => $schoolparts
                 ));

    }

    /**
     * Backend Updater Article
     *
     * @return Redirect
     */
    public function updateArticle($id)
    {
        $article = ArticleModel::findOrFail($id);

        extract(Input::all());

	    $article->title = $title;
        $article->content = $content;
        $article->active = $active;
        $article->updown = $updown;

        $article->save();

        $delete_catagory = Article_catagoryModel::where('article_id','=',$id)->delete();
        foreach($catagories as $catagory){
            $article_catagory = new Article_catagoryModel;
            $article_catagory->article_id = $id;
            $article_catagory->catagory_id = $catagory;
            $article_catagory->save();
        }
        $delete_schoolpart = Article_schoolpartModel::where('article_id','=',$id)->delete();
        foreach($schoolparts as $schoolpart){
            $article_schoolpart = new Article_schoolpartModel;
            $article_schoolpart->article_id = $id;
            $article_schoolpart->schoolpart_id = $schoolpart;
            $article_schoolpart->save();
        }

        return Redirect::route('BackendShowArticle')
            ->with('success','文章修改成功');
    }

    /**
     * Backend Save Article
     *
     * @return Redirect
     */
    public function saveEdit()
    {
        $article = new ArticleModel;

        extract(Input::all());

        $article->title = $title;
        $article->content = $content;
        $article->user_id = $this->user->id;
        $article->user = $this->user->loginname;
        $article->active = $active;
        $article->updown = $updown;

        $article->save();

        $articleid = $article->id;
        foreach($catagories as $catagory){
            $article_catagory = new Article_catagoryModel;
            $article_catagory->article_id = $articleid;
            $article_catagory->catagory_id = $catagory;
            $article_catagory->save();
        }
        foreach($schoolparts as $schoolpart){
            $article_schoolpart = new Article_schoolpartModel;
            $article_schoolpart->article_id = $articleid;
            $article_schoolpart->schoolpart_id = $schoolpart;
            $article_schoolpart->save();
        }

        return Redirect::route('BackendShowArticle')
            ->with('success','文章保存成功');
    }

    /**
     * Backend Remove Article
     *
     * @return Redirect
     */
    public function removeArticle($id)
    {
        $article_action = ArticleModel::findOrFail($id);

        if($this->user->hasPermission('deleteallarticle')){
            if($article_action->user_id != $this->user->id){
                return App::abort(404);
            }
        }

        $article_catagory = $article_action->article_catagory()->delete();
        $article_schoolpart = $article_action->Article_schoolpart()->delete();
        $article = $article_action->delete();

        return Redirect::route('BackendShowArticle')
            ->with('success','文章删除成功');
    }

    /**
     * Backend Updown change Article
     *
     * @return Redirect
     */
    public function upDown($id)
    {
        $updown = ArticleModel::findOrFail($id);

        if($updown->updown == '0'){
             $updown['updown'] = '1';
            $message = '文章置顶成功';
        }else{
            $updown['updown'] ='0';
            $message = '文章取消置顶成功';
        }
        $updown->save();

        return Redirect::route('BackendShowArticle')
            ->with('success',$message);
    }

    /**
     * Backend Active change Article
     *
     * @return Redirect
     */
    public function updateActive($id)
    {
        $active = ArticleModel::findOrFail($id);

        if($active->active == '0'){
            $active['active'] = '1';
            $message = '文章发布成功';
        }else{
            $active['active'] = '0';
            $message = '文章状态为草稿，未发布';
        }
        $active->save();

        return Redirect::route('BackendShowArticle')
            ->with('success',$message);
    }

}
