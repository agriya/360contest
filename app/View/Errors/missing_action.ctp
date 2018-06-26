<?php $title_for_layout = __l('Page not found'); ?>
<h2><?php echo __l('Error'); ?></h2>
<p class="error">
    <?php echo __l('The requested address was not found on this server.'); ?>
    <!-- action -->
</p>
<?php Configure::write('debug', 0); ?>