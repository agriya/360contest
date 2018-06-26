<?php /* SVN: $Id: add.ctp 619 2009-07-14 13:25:33Z boopathi_23ag08 $ */ ?>
<div class="userFlags form js-add-user-flag-response">
<h2><?php echo __l('Flag This User');
$url = Router::url(array('controller'=>'users','action'=>'view',$User_add['User']['username']),true);
?></h2>
<div class="form-content-block">
<?php echo $this->Form->create('UserFlag', array('class' => 'normal js-ajax-form {container:"js-add-user-flag-response","redirect_url":"'.$url.'"}'));?>
	<fieldset>
	<?php
		echo $this->Form->input('other_user_id', array('type' => 'hidden'));
		echo $this->Form->input('user_flag_category_id', array('type' => 'select', 'options' => $UserFlagCategories));
		echo $this->Form->input('message');
    ?>
	</fieldset>
	<div class="submit-block clearfix">
        <?php echo $this->Form->submit(__l('Add'));?>
    </div>
        <?php echo $this->Form->end();?>
</div>
</div>