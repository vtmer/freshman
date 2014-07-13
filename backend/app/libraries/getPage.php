<?php

class getPage {

    /**
    * Get <a></a> of Previous
    *
    * @param int $currentPage
    * @param string $url
    * @return string
    */
    public static function getPrevious($currentPage, $url)
    {
        if ($currentPage <= 1)
            return '<li><a>上一页</a></li>';
        else
            return '<li><a href="'.$url.'">上一页</a></li>';
    }

    /**
    * Get <a></a> of next
    *
    * @param int $currentPage
    * @param int $lastPage
    * @param string $url
    * @return string
    */
    public static function getNext($currentPage, $lastPage, $url)
    {
        if ($currentPage >= $lastPage)
            return '<li><a>下一页</a></li>';
        else
            return '<li><a href="'.$url.'">下一页</a></li>';
    }

}
