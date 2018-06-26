<?php /* SVN: $Id: admin_manage.ctp 71269 2011-11-14 10:50:18Z josephine_065at09 $ */ ?>
<div class="hor-space">
<div class="thumbnail translations form">
  <div class="clearfix">
    <dl class="edit-translation span8 clearfix">
      <dt class="pull-left span4"><?php echo __l('Verified');?></dt>
      <dd><?php echo $this->Html->link($verified_count, array('controller' => 'translations', 'action' => 'manage', 'language_id' => $this->request->data['Translation']['language_id'], 'filter' => 'verified'), array('title' => __l('Verified')));?></dd>
      <dt class="pull-left span4"><?php echo __l('Unverified');?></dt>
      <dd><?php echo $this->Html->link($unverified_count, array('controller' => 'translations', 'action' => 'manage', 'language_id' => $this->request->data['Translation']['language_id'], 'filter' => 'unverified'), array('title' => __l('Unverified')));?></dd>
    </dl>
    <div class="span4">
      <?php /* Chart block */ ?>
      <?php
				$total = $verified_count + $unverified_count;
				$verified_percent =  round($verified_count*100/$total,3);
				$unverified_percent =  round($unverified_count*100/$total,3);
				$translate_verfified_percentage = $verified_percent.",".$unverified_percent;
				echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$translate_verfified_percentage.'&amp;chs=70x70&amp;chco=74B732|C1C1BA&amp;chf=bg,s,FF000000', array('title' => __l('Verified: ').$verified_percent.'%'));
			?>
      <?php /* Chart block ends*/ ?>
    </div>
  </div>
  <div class="alert alert-info"> <?php echo __l('If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.');?> </div>
  <?php echo $this->Form->create('Translation', array('action' => 'manage', 'class' => 'form-horizontal')); ?>
  <fieldset>
		<?php
      echo $this->Form->input('language_id');
      echo $this->Form->input('filter', array('type' => 'hidden'));
      echo $this->Form->input('q', array('label' => __l('Keyword')));
    ?>
    <div class="submit-block clearfix">
      <?php
        echo $this->Form->submit(__l('Submit'), array('name' => 'data[Translation][makeSubmit]'));
      ?>
    </div>
		<?php
      if(!empty($translations)):
        echo $this->element('paging_counter');
      endif;
        echo $this->Form->input('page', array('type' => 'hidden'));
    ?>
    <table class="table table-striped">
      <tr>
        <th class="select"><?php echo __l('Verified'); ?></th>
        <th><?php echo __l('Original'); ?></th>
        <th><?php echo __l('Translated'); ?></th>
      </tr>
      <?php
        if(!empty($translations)):
          foreach ($translations as $translation):
      ?>
        <tr>
          <td class="select"><?php echo $this->Form->input('Translation.'.$translation['Translation']['id'].'.is_verified', array('checked' => ($translation['Translation']['is_verified'])?true:false, 'class' => '', 'label' => false)); ?></td>
          <td><?php echo $translation['Translation']['name']; ?></td>
          <td><?php echo $this->Form->input('Translation.'.$translation['Translation']['id'].'.lang_text', array('label' => false, 'value' => $translation['Translation']['lang_text'])); ?></td>
        </tr>
        <?php
          endforeach;
        ?>
        <tr>
          <td colspan="3">
            <div class="submit-update-block clearfix offset9 space">
              <?php
                echo $this->Form->submit(__l('Update'), array('name' => 'data[Translation][makeUpdate]'));
              ?>
            </div>
           </td>
        </tr>
        <?php
          else:
        ?>
        <tr>
          <td colspan="2" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('translations'));?></td>
        </tr>
      <?php endif;?>
    </table>
		<div class="pull-right"><?php
      if(!empty($translations)):
        echo $this->element('paging_links');
      endif;
    ?></div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
</div>
