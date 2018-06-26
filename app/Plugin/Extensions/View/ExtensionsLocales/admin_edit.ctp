<div class="extensions-locales">
    <h2><?php echo $title_for_layout; ?></h2>
    <?php
        echo $this->Form->create('Locale', array(
            'url' => array(
                'controller' => 'extensions_locales',
                'action' => 'edit',
                $locale
            ),
			array('class' => 'form-horizontal')
        ));
    ?>
    <fieldset>
    <?php
        echo $this->Form->input('Locale.content', array(
            'label' => __l('Content'),
            'value' => $content,
            'type' => 'textarea',
            'class' => 'content',
        ));
    ?>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->end(__l('Save'));
        echo $this->Html->link(__l('Cancel'), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>