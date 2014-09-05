<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 30.09.12
 * Time: 13:47
 * To change this template use File | Settings | File Templates.
 */
class RsideWidget extends CWidget {
    public $key = '';
    public $excludeNewsId = 0;

    public function init() {
        $newsIds = News::model()->getRelatedIdByTag($this->key, 2, $this->excludeNewsId);
        $news = News::model()->findAllByPk($newsIds);
        $clipIds = Clips::model()->getRelatedIdByTag($this->key, 2);
        //$clips = Clips::model()->findAllBy($clipIds);
        $clips = Clips::model()->findAllBySql("
            SELECT * FROM clips WHERE id IN (".join(',', array_merge($clipIds, array(0))).") AND approved = 1 AND dateShow < Now()
        ");
        $eventsId = Events::model()->getRelatedIdByTag($this->key, 1);
        $events = Events::model()->findAllByPk($eventsId, 'approved=1 AND EventDate>"' . Yii::app()->dateFormatter->format("yyyy-MM-dd kk:mm:ss", time()) . '"');
        $this->render('rside', array(
            'news' => $news,
            'clips' => $clips,
            'events' => $events
        ));
    }
}
