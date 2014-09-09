<?php
namespace Emall\Controller;
use Emall\Controller\SiteController;
/**
 * 站点首页
 */

class IndexController extends SiteController {

	/**
     * 主页
     */
    public function index(){
    	//MEDIA信息
        $media=$this->getMedia();
    	$this->assign('media', $media);
        $this->siteDisplay(C('TPL_INDEX'));
    }
}