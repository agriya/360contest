<?php
    echo sprintf(__l('A new comment has been posted under: %s'),$node['Node']['title']) . "\n \n";

    echo Router::url($node['Node']['url'], true) . '#comment-' . $commentId . "\n \n";
    
    echo sprintf(__l('Name: %s'), $data['name']) . "\n";
    echo sprintf(__l('Email: %s'), $data['email']) . "\n";
    echo sprintf( __l('Website: %s'), $data['website']) . "\n";
    echo sprintf(__l('IP Address: %s'), $data['ip']) . "\n";
    echo sprintf(__l('Comment: %s'), $data['body']) . "\n";
?>