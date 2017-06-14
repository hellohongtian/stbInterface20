<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/10
 * Time: 下午11:22
 */

namespace v300\components\param;

use v300\components\error\ErrorAction;

class ParamForm extends ParamRule
{
    
    /**
     * 本类中返回的的默认错误名称
     * @var
     */
    private $error_name = 'param_error';

    /**
     * 接口名称: ControllerID-ActionID
     * @var
     */
    private $interfaceName;



    public function __construct($interfaceName, array $config=[])
    {
        parent::__construct($config);
        $this->setInterfaceName($interfaceName);
    }

    /**
     * 设置待校验接口的名称
     */
    public function setInterfaceName($interfaceName)
    {
        $this->interfaceName = $interfaceName;
    }

    /**
     * 校验规则
     * @return mixed
     */
    public function rules()
    {
        //获取不同的规则
        return $this->getRule();
    }


    /**
     * Returns param values.
     * @return array attribute values (name => value).
     */
    public function getParams()
    {
        $values = [];
        $names = ParamProperty::$propertyList[$this->interfaceName];
        foreach ($names as $name) {
            $values[$name] = $this->$name;
        }
        return $values;
    }


    /**
     * 根据接口名称,获取不同的校验规则
     * @return mixed
     */
    private function getRule()
    {
        // 各个接口的字段名称列表
        if(isset(ParamProperty::$propertyList[$this->interfaceName])){
            $rules = [];
            foreach (ParamProperty::$propertyList[$this->interfaceName] as $propertyName){
                $rule = $this->getPropertyRule($propertyName);
                $rules = array_merge($rules,$rule);
            }
            return $rules;
        }else{
            ErrorAction::getInstance()->throwError( $this->error_name );
        }
    }


    /**
     * 获取字段属性的验证规则
     */
    private function getPropertyRule($propertyName)
    {
        if(isset(ParamRule::$RuleList[$propertyName])){
            return ParamRule::$RuleList[$propertyName];
        }else{
            ErrorAction::getInstance()->throwError( $this->error_name );
        }
    }

}