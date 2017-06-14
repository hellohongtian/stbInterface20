<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/13
 * Time: 下午4:38
 */

namespace v300\models\lists;


class Category extends \v300\components\InterfaceModel
{
    public function getData($params)
    {
        $data = $this->getCollection()->aggregate([
            [ '$match' => [ 'display' => 1 ,'root_id' => $params['root_id'], "property.market.".$params['market'] => 1 ] ],
            [ '$sort' => [ 'sequence' => 1 ], ],
            [ '$project' => ['category_id' => '$_id','name' => '$property.name', '_id' => 0] ],
        ]);
        return [ 'result' => $data ];
    }
}