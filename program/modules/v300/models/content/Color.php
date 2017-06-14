<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/4/19
 * Time: 16:58
 */
namespace v300\models\content;

class Color extends \v300\components\InterfaceModel
{

    public function getData($params)
    {
        $data = $this->getCollection()->aggregate([
            [ '$project' => [
                'root_id'=>'$root_id',
                'color_list'=>[
                    'color_type'=>'$color_data.color_type',
                    'color_position' => '$property.color_position',
                    'color_content'=>'$color_data.color_content',
                ],
                '_id'=> 0
                ],
            ],
        ]);

        return ['result' => $data];
    }
}