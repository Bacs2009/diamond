<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

class RegisterScriptFile_SetNode extends Twig_Node {
    protected $name;
    protected $value;

    public function __construct(Twig_Node_Expression $url, $position, $lineno, $tag = null) {
        parent::__construct(array('url' => $url), array('position'=>$position) , $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler) {

        $compiler
            ->addDebugInfo($this)
            ->write('Yii::app()->clientScript->registerScriptFile(')
            ->subcompile($this->getNode('url'))
            ->write(','.($this->getAttribute('position') ? '\''.$this->getAttribute('position').'\'' : 'null'))
            ->raw(");\n");
    }

}
 
