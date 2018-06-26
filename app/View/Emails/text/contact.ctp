<?php
    $url = Router::url(array(
        'controller' => 'contacts',
        'action' => 'view',
        $contact['Contact']['alias'],
    ), true);
    echo sprintf(__l('You have received a new message at: %s'), $url) . "\n \n";
    echo sprintf(__l('Name: %s'), $message['Message']['name']) . "\n";
    echo sprintf(__l('Email: %s'), $message['Message']['email']) . "\n";
    echo sprintf(__l('Subject: %s'), $message['Message']['title']) . "\n";
    echo sprintf(__l('IP Address: %s'), $_SERVER['REMOTE_ADDR']) . "\n";
    echo sprintf(__l('Message: %s'), $message['Message']['body']) . "\n";
?>