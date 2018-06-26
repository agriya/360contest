<div class="comments">
<?php
    $commentHeading = $node['Node']['comment_count'] . ' ';
    if ($node['Node']['comment_count'] == 1) {
        $commentHeading .= __l('Comment');
    } else {
        $commentHeading .= __l('Comments');
    }
    echo $this->Html->tag('h3', $commentHeading);

    foreach ($comments AS $comment) {
        echo $this->element('comment', array('comment' => $comment, 'level' => 1, 'cache' => array('config' => 'sec')));
    }
?>
</div>