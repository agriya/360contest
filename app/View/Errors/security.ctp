<?php $title_for_layout = __l('Page not found'); ?>
<h2><?php echo __l('Security Error'); ?></h2>
<p class="error">
    <?php echo __l('The requested address was not found on this server.'); ?>
</p>
<?php if (Configure::read('debug') > 0): ?>
<p class="notice">
    Request blackholed due to "<?php echo $type; ?>" violation.
</p>
<?php endif; ?>
<?php Configure::write('debug', 0); ?>