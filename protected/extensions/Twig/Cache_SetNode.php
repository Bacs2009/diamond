<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

class Cache_SetNode extends Twig_Node {
    protected $name;
    protected $value;

    public function __construct($key, $duration, $lineno, $tag = null) {
        parent::__construct(array(), array('key' => $key, 'duration' => $duration) , $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler) {
        $compiler
            ->addDebugInfo($this)
            ->write('if( $context["this"]->beginCache(\''.$this->getAttribute('key').'\'')
            //->subcompile($this->getNode('value'))
            ->write(", array('duration'=>".$this->getAttribute('duration')."))){;\n echo time();\n")
            ->write('$context["this"]->endCache();}')
            ->raw("\n");
    }

}
 
