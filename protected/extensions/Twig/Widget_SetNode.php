<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

class Widget_SetNode extends Twig_Node {
    protected $name;
    protected $value;

    public function __construct($class, Twig_Node_Expression $value, $lineno, $tag = null) {
        parent::__construct(array('value' => $value), array('class' => $class) , $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler) {
        $compiler
            ->addDebugInfo($this)
            ->write('$context["this"]->widget(\''.$this->getAttribute('class').'\', ')
            ->subcompile($this->getNode('value'))
            ->raw(");\n");
    }

}
 
