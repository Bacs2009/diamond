<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 30.08.12
 * Time: 18:16
 * To change this template use File | Settings | File Templates.
 */

class ARFiltersBehavior extends CActiveRecordBehavior {

    public function dateTimeFilter($val) {
        $datetime = explode(' ', $val);
        $date = join('-', array_reverse(explode('.', $datetime[0])));
        return count($datetime) == 2 ? $date . " " . $datetime[1] : $date;
    }

    public function purifyRich($val) {
        $p = new CHtmlPurifier();
        $p->options = array(
            'HTML.Allowed' => 'div[title|style|class], p[style], ul, ol, li, a[href], b, span[style|class], img[src|alt|title], strong, i, em, s, u, blockquote, sup, sub, pre, br',
            'URI.AllowedSchemes' => array('http', 'https', 'mailto'),
        );
        return trim(str_replace("\n", "", $p->purify($val)));
    }

    public function purifyLink($val) {
        $p = new CHtmlPurifier();
        $p->options = array(
            'HTML.Allowed' => 'a[href|target]',
            'URI.AllowedSchemes' => array('http', 'https', 'mailto'),
        );
        return trim(str_replace("\n", "", $p->purify($val)));
    }

    public function purifyStrong($val) {
        $p = new CHtmlPurifier();
        $p->options = array(
            'HTML.Allowed' => '',
            'URI.AllowedSchemes' => array(),
        );
        return trim(str_replace("\n", "", $p->purify($val)));
    }

    public function mb_ucfirst($word) {
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');
    }

}
