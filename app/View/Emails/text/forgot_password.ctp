<?php echo sprintf(__l('Hello %s'), $user['User']['name']); ?>,

<?php
    $url = Router::url(array(
        'controller' => 'users',
        'action' => 'reset',
        $user['User']['username'],
        $activationKey,
    ), true);
    echo sprintf(__l('Please visit this link to reset your password: %s'), $url);
?>


<?php echo __l('If you did not request a password reset, then please ignore this email.'); ?>


<?php echo sprintf(__l('IP Address: %s'), $_SERVER['REMOTE_ADDR']); ?>