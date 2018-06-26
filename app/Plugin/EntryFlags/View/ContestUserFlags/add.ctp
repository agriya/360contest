<?php /* SVN: $Id: add.ctp 619 2009-07-14 13:25:33Z boopathi_23ag08 $ */ ?>
<div class="ContestUserFlags form js-add-contest-flag-response">
<h2><?php echo __l('Report Abuse');?></h2>
<div class="form-content-block">
<?php echo $this->Form->create('ContestUserFlag', array('class' => "js-ajax-form {container:'js-add-contest-flag-response'} normal"));?>
	<fieldset>
	<?php
		echo $this->Form->input('contest_user_id', array('type' => 'hidden'));
		echo $this->Form->input('entry', array('type' => 'hidden'));
		echo $this->Form->input('page', array('type' => 'hidden'));
		echo $this->Form->input('contest_user_flag_category_id', array('label' => __l('Entry Flag 

Category'), 'type' => 'select', 'options' => $ContestUserFlagCategories));
		echo $this->Form->input('message');
    ?>
	</fieldset>
	<div class="submit-block clearfix">
        <?php echo $this->Form->submit(__l('Submit'));?>
    </div>
        <?php echo $this->Form->end();?>
</div>
</div>