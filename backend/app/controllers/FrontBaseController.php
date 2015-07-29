<?php namespace Controllers;

use Controller;
use Catagory as CatagoryModel;
use SchoolPart as SchoolPartModel;
use View;
use Cookie;
use Response;
use Redirect;
use Config;


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


    /**
     * FrontBaseController construct
     *
     * DO: get global catagorise and SchoolParts
     *     set the current SchoolPart according Cookie
     *
     * @return Null
     */
    public function __construct()
    {
        $this->catagories = CatagoryModel::all();
        $this->schoolParts = SchoolPartModel::all();

        if(!Cookie::get('PartId')) {
            $tmpSchoolPartId = Config::get('freshman.initSchoolPart');
            Cookie::queue('PartId', $tmpSchoolPartId);
            $this->schoolPartId = $tmpSchoolPartId;
        } else {
            $this->schoolPartId = Cookie::get('PartId');
        }

        //交换校区的位置，数组下标0为当前校区
        $tempSchoolPart = $this->schoolParts[0];
        $this->schoolParts[0] = $this->schoolParts[$this->schoolPartId - 1];
        $this->schoolParts[$this->schoolPartId - 1] = $tempSchoolPart;

        View::share(array(
            'catagories' => $this->catagories,
            'schoolParts' => $this->schoolParts,
            'schoolPartId' => $this->schoolPartId
        ));
    }

    /**
     * get the Catagory and relevant article
     *
     * @return Array
     */
    public function getCatagoryArticle($articleNumber)
    {
		$schoolPart = SchoolPartModel::find($this->schoolPartId);
        foreach(CatagoryModel::all() as $catagory) {
            $catagory['articles'] = CatagoryModel::find($catagory['id'])
                ->articles()
                ->join('article_schoolpart','article.id','=','article_schoolpart.article_id')
                ->orderBy('updown','desc')
                ->orderBy('id','desc')
                ->where('active','=',1)
                ->where('schoolpart_id','=',$schoolPart['id'])
                ->limit($articleNumber)
                ->get();
            $catagories[] = $catagory;
        }

        return $catagories;
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

    /**
     * 判断是否是移动设备
     *
     * @return boolean
     */
    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array (
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i",
                strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||
                (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }

        return false;
    }

}
