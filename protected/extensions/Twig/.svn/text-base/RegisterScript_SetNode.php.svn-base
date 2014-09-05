<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

class RegisterScript_SetNode extends Twig_Node {
    protected $name;
    protected $value;

    public function __construct($id, $script, $position, $lineno, $tag = null) {
        parent::__construct(array('id' => $id, 'script'=> $script), array('position'=>$position) , $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler) {
        // registerScript(string $id, string $script, integer $position=NULL)

        $compiler
            ->addDebugInfo($this)
            ->write('Yii::app()->clientScript->registerScript(')
            ->subcompile($this->getNode('id'))
            ->write(',')
            ->subcompile($this->getNode('script'))
            ->write(', '.($this->getAttribute('position') ? '\''.$this->getAttribute('position').'\'' : 'null'))
            ->raw(");\n");
    }

}
 
