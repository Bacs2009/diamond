<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'views/layouts/column1.twig';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $adminMenu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

				if(isset($_GET['language']))
				{
					Yii::app()->params->language = $_GET['language'];
					Yii::app()->language = Yii::app()->params->locales[$_GET['language']];
				}

/*
        $this->menu = array(
            'items' => array(
              //  array('label' => 'Магазины', 'url' => array('#'), 'active' => in_array($this->id, array('shops','city')),'items' => array(
              //      array('label' => 'Города', 'url' => array('/city/index')),
              //      array('label' => 'Магазины', 'url' => array('/shops/index'))
              //  )),
               // array('label' => 'Новини', 'url' => array('/news/index'), 'active' => $this->id == 'news'),
               // array('label' => 'Афіша', 'url' => array('/events/index'), 'active' => in_array($this->id, array('events'))),
                //array('label' => 'Акції', 'url' => array('/actions/index')),
                //array('label' => 'Хіт паради', 'url' => array('/chart/index'), 'active' => ($this->id == 'chart')||($this->id == 'webparad')||($this->id == 'kingsbridge')),
            ),
            'activateItems' => true,
            'activateParents' => true,
            'htmlOptions' => array(
                'id' => 'MainMenu'
            ),
            'submenuHtmlOptions' => array(
                'class' => 'has_sub'
            )
        );
*/

        $this->adminMenu = array(
            'items' => array(
                array('label' => 'Магазины', 'url'=> array('admin/shops/index'),'items'=>array(
                    array('label' => 'Города', 'url' => array('admin/cityItem/index')),
                    array('label' => 'Магазины', 'url' => array('admin/shops/index'))
                )),
                array('label' => 'Кольца', 'url'=> array('admin/rings/index'),'items'=>array(
                    //array('label' => 'Кольца', 'url' => array('admin/rings/index')),
                    array('label' => 'Коллекции', 'url' => array('admin/collection/index')),
                    array('label' => 'Заказы', 'url' => array('admin/order/index'))
                )),
                array('label' => 'Акции', 'url'=> array('admin/actions/index')),
            
                array('label' => 'Прочее', 'url' => array('admin/menu'), 'items' => array(
                    array('label' => 'Управление меню', 'url' => array('admin/menu')),
                    array('label' => 'Ссылки в футере', 'url' => array('admin/footerLinks')),
                    array('label' => 'Шаблон письма "отправить другу"', 'url' => array('admin/letter/index')),
					          array('label' => 'Шаблон письма "заказать"', 'url' => array('admin/oletter/index')),
					          array('label' => 'Шаблон письма "заявка"', 'url' => array('admin/ohletter/index')),
                    array('label' => 'О компании', 'url' => array('admin/about/index')),
                    array('label' => 'Сервис', 'url' => array('admin/service/index'))
                )),
                array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
            ),
            'activateItems' => true,
            'activateParents' => true,
            'htmlOptions' => array(
                'id' => 'MainMenu'
            ),
            'submenuHtmlOptions' => array(
                'class' => 'has_sub'
            )
        );
    }
}