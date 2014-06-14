<?php

class strFilter {

    /**
     * 过滤HTML 并截取过滤后的字符串
     *
     * @param string $value
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    public static function filterHtmlLimit($value, $limit = 60, $end = '...')
    {
        $value = strip_tags($value);
        if(mb_strlen($value) <= $limit) return $value;

        return mb_substr($value, 0, $limit, 'UTF-8').$end;
    }
}
