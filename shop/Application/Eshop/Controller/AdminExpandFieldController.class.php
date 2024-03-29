<?php
namespace Eshop\Controller;
use Admin\Controller\AdminController;
/**
 * 扩展模型字段管理
 */
class AdminExpandFieldController extends AdminController
{
    /**
     * 当前模块参数
     */
    public function _infoModule()
    {
        $info = A('Eshop/AdminExpand');
        $info = $info->infoModule;
        $fieldsetId = I('get.fieldset_id', 0, 'intval');
        $data = array('info' => $info['info'],
            'menu' => array(
                array('name' => '模型列表',
                    'url' => U('AdminExpand/index'),
                    'icon' => 'list',
                    ),
                array('name' => '字段列表',
                    'url' => U('index', array('fieldset_id' => $fieldsetId)),
                    'icon' => 'list-ul',
                    ),
                array('name' => '增加字段',
                    'url' => U('add', array('fieldset_id' => $fieldsetId)),
                    'icon' => 'plus',
                    ),
                )
            );
        return $data;
    }

    /**
     * 列表
     */
    public function index()
    {
        $fieldsetId = I('get.fieldset_id', 0, 'intval');
        if (empty($fieldsetId))
        {
            $this->error('参数不能为空！');
        }
        $model = D('FieldsetExpand');
        $fieldsetInfo = $model->getInfo($fieldsetId);
        if (!$fieldsetInfo)
        {
            $this->error($model->getError());
        }
        $where = array();
        $where['A.fieldset_id'] = $fieldsetId;
        $list = D('FieldExpand')->loadList($where);
        $breadCrumb = array('模型列表' => U('AdminExpand/index'), '字段列表' => U('index', array('fieldset_id' => $fieldsetId)));
        $this->assign('breadCrumb', $breadCrumb);
        $this->assign('list', $list);
        $this->assign('fieldsetInfo', $fieldsetInfo);
        $this->assign('typeField', D('Field')->typeField());
        $this->adminDisplay();
    }

    /**
     * 增加
     */
    public function add()
    {
        if (!IS_POST)
        {
            $fieldsetId = I('get.fieldset_id', 0, 'intval');
            if (empty($fieldsetId))
            {
                $this->error('参数不能为空！');
            }
            $model = D('FieldsetExpand');
            $fieldsetInfo = $model->getInfo($fieldsetId);
            if (!$fieldsetInfo)
            {
                $this->error($model->getError());
            }
            $breadCrumb = array('模型列表' => U('AdminExpand/index'), '字段列表' => U('index', array('fieldset_id' => $fieldsetId)), '字段添加' => U());
            $this->assign('breadCrumb', $breadCrumb);
            $this->assign('name', '添加');
            $this->assign('fieldsetInfo', $fieldsetInfo);
            $this->assign('typeField', D('Field')->typeField());
            $this->assign('propertyField', D('Field')->propertyField());
            $this->assign('typeVerify', D('Field')->typeVerify());
            $this->assign('ruleVerify', D('Field')->ruleVerify());
            $this->assign('ruleVerifyJs', D('Field')->ruleVerifyJs());
            $this->adminDisplay('info');
        }
        else
        {
            $model = D('FieldExpand');
            if ($model->saveData('add'))
            {
                $this->success('字段添加成功！');
            }
            else
            {
                $msg = $model->getError();
                if (empty($msg))
                {
                    $this->error('字段添加失败');
                }
                else
                {
                    $this->error($msg);
                }
            }
        }
    }

    /**
     * 修改
     */
    public function edit()
    {
        $model = D('FieldExpand');
        if (!IS_POST)
        {
            $fieldId = I('get.field_id', 0, 'intval');
            if (empty($fieldId))
            {
                $this->error('参数不能为空！');
            }
            $info = $model->getInfo($fieldId);
            if (!$info)
            {
                $this->error($model->getError());
            }
            $fieldsetInfo = D('FieldsetExpand')->getInfo($info['fieldset_id']);
            $breadCrumb = array('模型列表' => U('AdminExpand/index'), '字段列表' => U('index', array('fieldset_id' => $fieldsetInfo['fieldset_id'])), '字段修改' => U('edit',array('field_id'=>$fieldId,'fieldset_id'=>$fieldsetInfo['fieldset_id'])));
            $this->assign('breadCrumb', $breadCrumb);
            $this->assign('name', '修改');
            $this->assign('info', $info);
            $this->assign('fieldsetInfo', $fieldsetInfo);
            $this->assign('typeField', D('Field')->typeField());
            $this->assign('propertyField', D('Field')->propertyField());
            $this->assign('typeVerify', D('Field')->typeVerify());
            $this->assign('ruleVerify', D('Field')->ruleVerify());
            $this->assign('ruleVerifyJs', D('Field')->ruleVerifyJs());
            $this->adminDisplay('info');
        }
        else
        {
            if ($model->saveData('edit'))
            {
                $this->success('字段修改成功！');
            }
            else
            {
                $msg = $model->getError();
                if (empty($msg))
                {
                    $this->error('字段修改失败');
                }
                else
                {
                    $this->error($msg);
                }
            }
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        $fieldId = I('post.data');
        if (empty($fieldId))
        {
            $this->error('参数不能为空！');
        } 
        // 删除操作
        $model = D('FieldExpand');
        if ($model->delData($fieldId))
        {
            $this->success('字段删除成功！');
        }
        else
        {
            $msg = $model->getError();
            if (empty($msg))
            {
                $this->error('字段删除失败！');
            }
            else
            {
                $this->error($msg);
            }
        }
    }
}

