<?php
class Article extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'article';

    /**
     * the attribute that allow to make a value together
     */
    protected $fillable = array('title','see','content','updown','user_id','user');

    /**
     * Catagory field declaration
     *
     * @return object;
     */
    public function catagories()
    {
        return $this->belongsToMany('Catagory','article_catagory',
            'article_id','catagory_id');
    }

    /**
     * Article_catagory field declaration
     *
     * @return object;
     */
    public function article_catagory(){
        return $this->hasMany('Article_catagory');
    }

    /**
     * SchoolPart field declaration
     *
     * @return object
     */
    public function schoolparts()
    {
        return $this->belongsToMany('SchoolPart','article_schoolpart',
            'article_id','schoolpart_id');
    }

    /**
     * Article_schoolpart field declaration
     *
     * @return object
     */
    public function article_schoolpart()
    {
        return $this->hasMany('Article_schoolpart');
    }
}
