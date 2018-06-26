<?php
/**
 *
 * @package		360Contest
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 *
 */
class CakeformHelper extends AppHelper
{
    public $helpers = array(
        'Html',
        'Form'
    );
    /**
     * used in generating form fieldsets
     *
     * @access public
     */
    public $openFieldset = false;
    /**
     * Generates form HTMl
     *
     * @param array $formData
     *
     * @return string Form Html
     * @access public
     */
    function insert($formData)
    {
        $out = '';
            if (isset($formData['FormField'])) {
                foreach($formData['FormField'] as $field) {
                    $field['name'] = 'Form.' . $field['name'];
                    $out.= $this->_field($field);
					if (!empty($field['Attachment'])) {
                        $out.= "<div class='input'><span class='upload-img'>".$this->Html->cText($field['Attachment']['filename']) . $this->Html->link(__l('Delete') , array(
                            'action' => 'delete_attachment',
                            $this->request->data['Contest']['id'],
                            $field['Attachment']['id'],
							$field['Attachment']['foreign_id'],
                            'admin' => false
                        ) , array(
                            'class' => 'js-confirm delete blackc',
                            'escape' => false
                        )) . '</div>';
                    }
                }
            }
            if ($this->openFieldset == true) {
                $out.= "</fieldset>";
            }
        return $this->output($out);
    }
    /**
     * Generates appropriate html per field
     *
     * @param array $field Field to process
     * @parram array $custom_options Custom $this->Forminput options for field
     *
     * @return string field html
     * @access public
     */
    function _field($field, $custom_options = array())
    {
        $required = '';
        if ($field['required'] == 1) {
            $required = 'required';
        }
        $options = array();
        $out = '';
        if (!empty($field['type'])) {
            switch ($field['type']) {
                case 'fieldset':
                    if ($this->openFieldset == true) {
                        $out.= "</fieldset>";
                    }
                    $out.= "<fieldset>";
                    $this->openFieldset = true;
                    if (!empty($field['name'])) {
                        $out.= "<legend>" . Inflector::humanize($field['label']) . "</legend>";
                        $out.= $this->Form->hidden('fs_' . $field['name'], array(
                            'value' => $field['name']
                        ));
                    }
                    break;

                case 'textonly':
                    $out = $this->Html->para('textonly', $field['label']);
                    break;

                default:
                    $options['type'] = $field['type'];
                    $options['info'] = $field['info'];
                    if (in_array($field['type'], array(
                        'select',
                        'checkbox',
                        'radio'
                    ))) {
                        if ($field['type'] == 'checkbox') {
                            if (count($field['options']) > 1) {
                                $options['type'] = 'select';
                                $options['multiple'] = 'checkbox';
                                $options['options'] = $this->explode_escaped(',', $field['options']);
                            } else {
                                $options['value'] = $field['name'];
                            }
                        } else {
                            $options['options'] = $this->explode_escaped(',', $field['options']);
                        }
                        if ($field['type'] == 'select' && !empty($field['multiple']) && $field['multiple'] == 'multiple') {
                            $options['multiple'] = 'multiple';
                        } elseif ($field['type'] == 'select') {
                            $options['empty'] = 'Please Select';
                        }
                    }
                    if (!empty($field['depends_on']) && !empty($field['depends_value'])) {
                        $options['class'] = 'dependent';
                        $options['dependsOn'] = $field['depends_on'];
                        $options['dependsValue'] = $field['depends_value'];
                    }
                    if (!empty($field['label'])) {
                        $options['label'] = $field['label'];
                        if ($field['type'] == 'radio') {
                            $options['legend'] = $field['label'];
                        }
                    }
                    if ($field['type'] == 'radio') {
                        $options['div'] = false;
                        $options['legend'] = false;
                        $out.= $this->Html->div('label-block label-block-radio ' . $required, $field['label']);
                    }
                    if ($field['type'] == 'slider') {
						$slider_options = $this->explode_escaped(',',  $field['options']);
						for ($num = 0; $num <= 100; $num++) {
                            $num_array[$num] = $num;
                        }
                        $options['div'] = 'input select slider-input-select-block clearfix offset4' . ' ' . $required;
                        $options['options'] = $num_array;
                        $options['type'] = 'select';
                        $options['class'] = 'js-uislider';
                        $options['data-slider_min'] = trim($slider_options[0]);
                        $options['data-slider_max'] = trim($slider_options[1]);
                        $options['label'] = false;
                        $i = 0;
                        $out.= $this->Html->div('label-block slider-label ' . $required, $field['label']);
                    }
                    if ($field['type'] == 'date') {
						$options['div'] = 'js-datetime' . ' ' . $required;
                        $options['orderYear'] = 'asc';
                        $options['minYear'] = date('Y') -10;
                        $options['maxYear'] = date('Y') +10;
                    }
                    if ($field['type'] == 'datetime') {
						$options['div'] = 'clearfix';
                        $options['div'] = 'input text js-datetime' . ' ' . $required;
                        $options['orderYear'] = 'asc';
                        $options['minYear'] = date('Y') -10;
                        $options['maxYear'] = date('Y') +10;
                    }
                    if ($field['type'] == 'time') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input time' . ' ' . $required;
                        $options['orderYear'] = 'asc';
                        $options['timeFormat'] = 12;
                        $options['type'] = 'time';
                    }
                    if ($field['type'] == 'color') {
                        $options['div'] = 'input text clearfix' . ' ' . $required;
                        $options['class'] = 'js-colorpick';
                        if (!empty($field['info'])) {
                            $info = $field['info'] . ' <br>Comma separated RGB hex code. You can use color picker.';
                        } else {
                            $info = 'Comma separated RGB hex code. You can use color picker.';
                        }
                        $options['info'] = $info;
                        $options['type'] = 'text';
                    }
                    if ($field['type'] == 'thumbnail') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text' . ' ' . $required;
                    }
					if ($field['type'] == 'file') {
                        $options['div'] = 'input file' . ' ' . $required;
                    }
                    if (!empty($field['default']) && empty($this->data['Form'][$field['name']])) {
                        $options['value'] = $field['default'];
                    }
                    if ($field['type'] == 'text') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text' . ' ' . $required;
                    }
                    if ($field['type'] == 'textarea') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input textarea' . ' ' . $required;
                    }
                    if ($field['type'] == 'select') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input select' . ' ' . $required;
                        if (!empty($field['multiple']) && $field['multiple'] == 'multiple') {
                            $options['div'].= ' multi-select';
                        }
                    }
                    $options = Set::merge($custom_options, $options);
                    if ($field['type'] == 'date' || $field['type'] == 'datetime') {
                        $out.= '<div class="input dob-block clearfix ' . $required . '"><div class="clearfix js-boostarp-datetime"><div class="clearfix js-cake-date">';
                    }
					if ($field['type'] == 'time') {
                        $out.= '<div class="clearfix  pr date-time-block ' . $required . '"><div class="input select left-space"> <div class="js-timepicker"> <div class="js-cake-date">';
                    }
                    if ($field['type'] == 'radio') {
                        $out.= '<div class="input radio radio-block clearfix">';
                    }
                    $out.= $this->Form->input($field['name'], $options);
                    if ($field['type'] == 'date' || $field['type'] == 'datetime') {
                        $out.= '</div></div></div>';
                    }
					if ($field['type'] == 'time') {
                        $out.= '</div></div></div></div>';
                    }
                    if ($field['type'] == 'radio') {
                        $out.= '</div>';
                    }
                    break;
            }
        }
        return $out;
    }
	function explode_escaped($delimiter, $string) 
    {
        $exploded = explode($delimiter, $string);
        $fixed = array();
        for ($k = 0, $l = count($exploded); $k < $l; ++$k) {
            if ($exploded[$k][strlen($exploded[$k]) -1] == '\\') {
                if ($k+1 >= $l) {
                    $fixed[] = trim($exploded[$k]);
                    break;
                }
                $exploded[$k][strlen($exploded[$k]) -1] = $delimiter;
                $exploded[$k].= $exploded[$k+1];
                array_splice($exploded, $k+1, 1);
                --$l;
                --$k;
            } else $fixed[] = trim($exploded[$k]);
        }
        return $fixed;
    }
}
?>