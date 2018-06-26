<?php
    $this->set(compact('block'));
    $b = $block['Block'];
    $class = 'block block-' . $b['alias'];
    if ($block['Block']['class'] != null) {
        $class .= ' ' . $b['class'];
    }
?>
<?php echo $this->Layout->filter($b['body']); ?>