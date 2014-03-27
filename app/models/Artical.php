<?php
class Artical extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'artical';

    /**
     * the attribute that allow to make a value together
     */
    protected $fillable = array('title','see','content','frist');

    /**
     * Atical_catagory field declaration
     *
     * @return object;
     */
    public function catagories()
    {
        return $this->belongsToMany('Catagory','artical_catagory',
            'artical_id','catagory_id');
    }
}
