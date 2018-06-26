<div class="extensions-locales">
    <h2><?php echo $title_for_layout; ?></h2>
    <?php
        echo $this->Form->create('Locale', array(
            'url' => array(
                'controller' => 'extensions_locales',
                'action' => 'add',
            ),
            'type' => 'file',
			array('class' => 'form-horizontal')
        ));
    ?>
    <fieldset>
    <?php
        echo $this->Form->input('Locale.file', array('label' => __l('Upload'), 'type' => 'file',));
    ?>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->end(__l('Upload'));
        echo $this->Html->link(__l('Cancel'), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>