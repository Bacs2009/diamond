<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 26.08.12
 * Time: 10:26
 * To change this template use File | Settings | File Templates.
 */

class StaticMapper extends CApplicationComponent {

    public $basePath;
    public $webBasePath;

    public function __construct() {
        $this->basePath = Yii::app()->basePath . "/../images/";
        $this->webBasePath = Yii::app()->baseUrl;
    }

    public function getPath($type, $id, $ext, $suffix = '') {
        $suffix = $suffix == '' ? '' : '_'.$suffix;
        $md5 = md5($type . $id);
        $path = $this->basePath . "$type/" . substr($md5, 0, 2) . "/" . substr($md5, 2, 2);
        if (!is_dir($path)) {
            mkdir($path, 0754, true);
        }
        return $path . "/" . $id . $suffix . "." . $ext;
    }

    public function getUrl($type, $id, $ext, $suffix = '') {
        $suffix = $suffix == '' ? '' : '_'.$suffix;
        $md5 = md5($type . $id);
        $path = "$type/" . substr($md5, 0, 2) . "/" . substr($md5, 2, 2);
        if (file_exists($this->basePath . $path . "/" . $id . $suffix . "." . $ext)) {
            return $this->webBasePath . '/images/' . $path . "/" . $id . $suffix . "." . $ext;
        } else {
		//return 'data:image/gif;base64,R0lGODlhAQABAPABAP///wAAACH5BAEKAAAALAAAAAABAAEAAAICRAEAOw%3D%3D';
		return '';
        }
    }
}
