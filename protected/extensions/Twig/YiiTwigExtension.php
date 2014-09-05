<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 19.08.12
 * Time: 00:43
 * To change this template use File | Settings | File Templates.
 */

class YiiTwigExtension extends Twig_Extension {

    public function getName() {
        return 'YiiTwigExtension';
    }

    public function getTokenParsers() {
        return array(
            new BeginWidget_TokenParser(),
            new EndWidget_TokenParser(),
            new Widget_TokenParser(),
            new RegisterScript_TokenParser(),
            new RegisterScriptFile_TokenParser(),
            new Cache_TokenParser()
        );
    }

    public function getFunctions() {
        return array(
            'beginWidget' => new Twig_Function_Function('$context["this"]->beginWidget'),
            'assetsPublish' => new Twig_Function_Function('Yii::app()->assetManager->publish'),
        );
    }

    public function getFilters() {
        return array_merge(parent::getFilters(), array(
            'date' => new Twig_Filter_Method($this, 'dateFilter'),
            'to_latin' => new Twig_Filter_Method($this, 'rus2translit'),
        ));
    }

    function dateFilter($timestamp, $format)
    {
        return Yii::app()->dateFormatter->format($format, $timestamp);
    }
    
    function rus2translit($string) {
    
        $converter = array(
    
            'а' => 'a',   'б' => 'b',   'в' => 'v',
    
            'г' => 'g',   'д' => 'd',   'е' => 'e',
    
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
    
            'и' => 'i',   'й' => 'y',   'к' => 'k',
    
            'л' => 'l',   'м' => 'm',   'н' => 'n',
    
            'о' => 'o',   'п' => 'p',   'р' => 'r',
    
            'с' => 's',   'т' => 't',   'у' => 'u',
    
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
    
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
    
            'ь' => '',  'ы' => 'y',   'ъ' => '\'',
    
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya', '.' => '', ' ' => '', 
    
            
    
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
    
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
    
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
    
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
    
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
    
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
    
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
    
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
    
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
    
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
    
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    
        );
    
        return strtr($string, $converter);
    
    }
    
}