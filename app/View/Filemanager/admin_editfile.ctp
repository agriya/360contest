<div class="filemanager form">
    <div class="breadcrumb">
    <?php
        echo __l('You are here:') . ' ';
        $breadcrumb = $this->Filemanager->breadcrumb($path);
        foreach($breadcrumb AS $pathname => $p) {
            echo $this->Filemanager->linkDirectory($pathname, $p);
            echo DS;
        }
    ?>
    </div>

    <?php
        echo $this->Form->create('Filemanager', array(
        'class' =>'normal',
            'url' => $this->Html->url(array(
                'controller' => 'filemanagers',
                'action' => 'editfile',
            ), true) . '?path=' . urlencode($absolutefilepath),
        ));
    ?>
    <fieldset>
    <?php echo $this->Form->input('Filemanager.content', array('type' => 'textarea', 'value' => $content, 'class' => 'content')); ?>
    </fieldset>

    <div class="submit-block clearfix">
    <?php  echo $this->Form->submit(__l('Save')); ?>
    <div class="cancel-block">
        <?php
        echo $this->Html->link(__l('Cancel'), array(
            'action' => 'index',
        ), array(
            'class' => '',
        ));
    ?>
    </div>
    </div>
       <?php  echo $this->Form->end(); ?>
</div>