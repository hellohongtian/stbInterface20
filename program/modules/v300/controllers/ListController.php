<?php

namespace app\modules\v300\controllers;

use v300\models\lists\Category;
use v300\models\lists\Online;
use Yii;
use v300\components\InterfaceController;
use v300\models\lists\Root;
use v300\components\error\ErrorAction;

class ListController extends InterfaceController
{

    /**
     * 获取首页导航
     */
    public function actionRoot()
    {

        $mongo = new Root();
        $data = $mongo->getData($this->params);
        return $data;
    }

    /**
     * 获取二级分类
     */
    public function actionCategory()
    {

        $category = new Category();
        $data = $category->getData($this->params);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError("not_exist_root");
        }
        return $data;
    }


    /**
     * 获取海报列表
     */
    public function actionOnline()
    {
        $online = new Online();
        $data = $online->getData($this->params);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError("not_exist_category");
        }
        return $data;
    }

}