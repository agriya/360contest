<?php /* SVN: $Id: add.ctp 619 2009-07-14 13:25:33Z boopathi_23ag08 $ */ ?>
<div class="contestFlags form js-add-contest-flag-response">
<h2><?php echo __l('Flag This Contest');
$url = Router::url(array('controller'=>'contests','action'=>'view',$Contest_add['Contest']['slug']),true);
?></h2>
<div class="form-content-block">
<?php echo $this->Form->create('ContestFlag', array('class' => 'normal js-ajax-form {container:"js-add-contest-flag-response","redirect_url":"'.$url.'"}'));?>
	<fieldset>
	<?php
		echo $this->Form->input('contest_id', array('type' => 'hidden'));
		echo $this->Form->input('contest_flag_category_id', array('type' => 'select', 'options' => $ContestFlagCategories));
		echo $this->Form->input('message');
    ?>
	</fieldset>
	<div class="submit-block clearfix">
        <?php echo $this->Form->submit(__l('Add'));?>
    </div>
        <?php echo $this->Form->end();?>
</div>
</div>