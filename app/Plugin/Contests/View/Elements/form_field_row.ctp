<?php
	$typeOptions['value'] = $field['options'];
	$typeOptions['type'] = 'text' ;
	$hide_class = '';
	if (!in_array($field['type'], $multiTypes)) {
		$hide_class = 'hide';
	}
	$typeOptions['info'] =__l('Comma separated. To include comma, escape it with \ (e.g., Option with \,)');
	$row = array(
	$this->Form->hidden('FormField.' . $key . '.id', array('value' => $field['id'])) .
	$this->Form->hidden('FormField.' . $key . '.contest_type_id', array('value' => $field['contest_type_id'])) .
	$this->Form->input('FormField.' . $key . '.label', array('label' => false, 'value' => $field['label'])),
	$this->Form->input('FormField.' . $key . '.display_text', array('label' => false, 'value' => $field['display_text'])),
    '<div class="grid_left select-field-block">'.
	$this->Form->input('FormField.' . $key . '.type', array('label' => false, 'value' => $field['type'],'class' => 'js-field-type-edit')) .
    '</div>'.
    '<div class="grid_13 options-field-block info-block ' . $hide_class.' ">'.
	$this->Form->input('FormField.' . $key . '.options', $typeOptions).
     '</div>',
	$this->Form->input('FormField.' . $key . '.info', array('label' => false, 'value' => $field['info'])),
	$this->Form->input('FormField.' . $key . '.required', array('label' => false, 'checked' => ($field['required']?'checked':''))),
	$this->Form->input('FormField.' . $key . '.is_active', array('label' => false, 'checked' => ($field['is_active']?'checked':''))),
	$this->Html->link('<i class="icon-remove"></i>' . __l('Remove'), array('controller'=>'form_fields','action' => 'delete', $field['id']), array('class' => 'ui-icon ui-icon-circle-close grayc js-form-field-delete js-confirm js-no-pjax', 'title' => __l('Remove'),'escape'=>false))
	);
	
	echo $this->Html->tableCells($row, array('class' => 'ui-state-default'),array('class' => 'ui-state-default'));
?>