<?php
namespace Eshop\Controller;
use Admin\Controller\AdminController;
/**
 * 栏目管理
 */
class AdminCategoryController extends AdminController
{
    /**
     * 当前模块参数
     */
    public function _infoModule()
    {
        $data = array('info' => array('name' => '栏目管理',
                'description' => '管理网站全部栏目',
                ),
            'menu' => array(
                array('name' => '栏目列表',
                    'url' => U('Eshop/AdminCategory/index'),
                    'icon' => 'list',
                    ),
                $contentMenu
                )
            );
        $modelList = getAllService('ContentModel', '');
        $contentMenu = array();
        if (!empty($modelList))
        {
            $i = 0;
            foreach ($modelList as $key => $value)
            {
                $i++;
                $data['menu'][$i]['name'] = '添加' . $value['name'] . '栏目';
                $data['menu'][$i]['url'] = U($key . '/AdminCategory/add');
                $data['menu'][$i]['icon'] = 'plus';
            }
        }
        return $data;
    }
    /**
     * 列表
     */
    public function index()
    {
        $breadCrumb = array('栏目列表' => U());
        $this->assign('breadCrumb', $breadCrumb);
        $this->assign('list', D('Category')->loadList());
        $this->adminDisplay();
    }
}

