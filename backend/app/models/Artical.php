<?php
class Artical extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'artical';

    /**
     * the attribute that allow to make a value together
     */
    protected $fillable = array('title','see','content','updown','user');

    /**
     * Catagory field declaration
     *
     * @return object;
     */
    public function catagories()
    {
        return $this->belongsToMany('Catagory','artical_catagory',
            'artical_id','catagory_id');
    }

    /**
     * Artical_catagory field declaration
     *
     * @return object;
     */
    public function artical_catagory(){
        return $this->hasMany('Artical_catagory');
    }
}
