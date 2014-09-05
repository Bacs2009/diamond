<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 17.08.12
 * Time: 22:56
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.CMenu');
class MainMenu extends CMenu {

    public function init() {
        Yii::app()->clientScript->registerCoreScript('jquery');
        $jqueryslidemenupath = Yii::app()->assetManager->publish(Yii::app()->basePath . '/assets/jqueryslidemenu/');
        Yii::app()->clientScript->registerCssFile($jqueryslidemenupath . '/jqueryslidemenu.css');
        Yii::app()->clientScript->registerScriptFile($jqueryslidemenupath . '/jqueryslidemenu.js');
        Yii::app()->clientScript->registerScript('menuinit','jqueryslidemenu.buildmenu($("#'.$this->id.'").parent().attr("id"), arrowimages);');
        parent::init();
    }
}
