<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

class EndWidget_SetNode extends Twig_Node {
    protected $name;
    protected $value;

    public function __construct($lineno, $tag = null) {
        parent::__construct(array(), array() , $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler) {
        $compiler
            ->addDebugInfo($this)
            ->write('$context["this"]->endWidget();')
            ->raw("\n");
    }

}
 
