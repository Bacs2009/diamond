<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 30.08.12
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */

class ARImageProcessingBehavior extends CActiveRecordBehavior {
    public $images;
    private $mode = array(
        'width' => 4,
        'height' => 3,
        'auto' => 2,
        'none' => 1,
        'outer' => 7
    );

    public function afterSave($event) {
        foreach ($this->images as $pseudo => $param) {
            $t = CUploadedFile::getInstance($this->getOwner(), $param['attribute']);
            if ($t) {
                $this->saveImages($t->tempName, $pseudo, $param);
            } else {
                $file = $this->getOwner()->getAttribute($param['attribute']);
                if (!empty($file)) {
                    $content = file_get_contents($file);
                    if ($content) {
                        $tmp = tempnam("/tmp", "");
                        file_put_contents($tmp, $content);
                    }
                    $this->saveImages($tmp, $pseudo, $param);
                }
            }
        }
    }

    public function getImageUrl($id = null,$type = 'jpg') {
		//print_r($this->images);
        foreach ($this->images as $pseudo => $param) {
			
            $res[$pseudo] = Yii::app()->mp->getUrl($this->getOwner()->tableName(), empty($id)
                    ? $this->getOwner()->getPrimaryKey()
                    : $id, $param['img_type'], $pseudo);
        }
		//print_r($res);
        return $res;
    }

    private function saveImages($tmpname, $pseudo, $param) {
        $image = Yii::app()->image->load($tmpname);
		if(isset($param['width'])){
			$image->resize($param['width'], $param['height'], $this->mode[$param['mode']])->quality(100);
		}
        if (isset($param['cropH']) && isset($param['cropV'])) {
            $image->crop($param['width'], $param['height'], $param['cropV'], $param['cropH']);
        }
        $image->save(Yii::app()->mp->getPath($this->getOwner()->tableName(), $this->getOwner()->getPrimaryKey(), $param['img_type'], $pseudo));

    }
}
