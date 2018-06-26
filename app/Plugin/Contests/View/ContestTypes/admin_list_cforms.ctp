<?php
echo $this->Html->scriptBlock('
			$(document).ready(function(){
                            $("#CformAdminListCformsForm").submit(function(){
				form_id = $("#CformCforms").val();
                                tinyMCE.execCommand("mceInsertContent",false,"{cform_"+form_id+"}");
                                $("#insert-cform").dialog("close");
                                return false;
                            });
                        });

			');
?>
<div>
<h4>Insert a Form</h4>
<p>To edit/create a form click <?php echo $this->Html->link('here', array('controller' => 'cforms', 'action' => 'index'));?>.</p>

<?php echo
    $this->Form->create(),
    $this->Form->input('cforms', array('empty' => 'Select a Form')),
    $this->Form->end('Insert Form');?>
</div>