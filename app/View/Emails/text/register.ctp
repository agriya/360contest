<?php echo sprintf(__l('Hello %s'), $user['User']['name']); ?>,

<?php
    $url = Router::url(array(
        'controller' => 'users',
        'action' => 'activate',
        $user['User']['username'],
        $user['User']['activation_key'],
    ), true);
    echo sprintf(__l('Please visit this link to activate your account: %s'), $url);
?>