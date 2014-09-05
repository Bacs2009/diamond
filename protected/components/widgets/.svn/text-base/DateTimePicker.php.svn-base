<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 17.08.12
 * Time: 22:56
 * To change this template use File | Settings | File Templates.
 */
class DateTimePicker extends CJuiInputWidget {
    /**
     * @var string the locale ID (eg 'fr', 'de') for the language to be used by the date picker.
     * If this property is not set, I18N will not be involved. That is, the date picker will show in English.
     * You can force English language by setting the language attribute as '' (empty string)
     */
    public $language;

    /**
     * @var string The i18n Jquery UI script file. It uses scriptUrl property as base url.
     */
    public $i18nScriptFile = 'jquery-ui-i18n.min.js';
    public $timepickerScriptFile = 'jquery-ui-timepicker-addon.js';

    /**
     * @var array The default options called just one time per request. This options will alter every other CJuiDatePicker instance in the page.
     * It has to be set at the first call of CJuiDatePicker widget in the request.
     */
    public $defaultOptions;

    /**
     * @var boolean If true, shows the widget as an inline calendar and the input as a hidden field. Use the onSelect event to update the hidden field
     */
    public $flat = false;

    /**
     * Run this widget.
     * This method registers necessary javascript and renders the needed HTML code.
     */

    public function run() {

        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];

        if ($this->flat === false) {
            if ($this->hasModel())
                echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
            else
                echo CHtml::textField($name, $this->value, $this->htmlOptions);
        }
        else
        {
            if ($this->hasModel()) {
                echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
                $attribute = $this->attribute;
                $this->options['defaultDate'] = $this->model->$attribute;
            }
            else
            {
                echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
                $this->options['defaultDate'] = $this->value;
            }

            if (!isset($this->options['onSelect']))
                $this->options['onSelect'] = new CJavaScriptExpression("function( selectedDate ) { jQuery('#{$id}').val(selectedDate);}");

            $id = $this->htmlOptions['id'] = $id . '_container';
            $this->htmlOptions['name'] = $name . '_container';

            echo CHtml::tag('div', $this->htmlOptions, '');
        }

        $options = CJavaScript::encode($this->options);
        $js = "jQuery('#{$id}').datetimepicker($options);";

        if ($this->language != '' && $this->language != 'en') {
            $this->registerScriptFile($this->i18nScriptFile);
            $this->registerScriptFile($this->timepickerScriptFile);
            $js = "jQuery('#{$id}').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";
        }

        $cs = Yii::app()->getClientScript();

        if (isset($this->defaultOptions)) {
            $this->registerScriptFile($this->i18nScriptFile);
            $this->registerScriptFile($this->timepickerScriptFile);
            $cs->registerScript(__CLASS__, $this->defaultOptions !== null
                                                 ? 'jQuery.datetimepicker.setDefaults(' . CJavaScript::encode($this->defaultOptions) . ');'
                                                 : '');
        }
        $cs->registerScript(__CLASS__ . '#' . $id, $js);

    }
}
