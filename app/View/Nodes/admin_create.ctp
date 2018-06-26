<div class="nodes create">
  <div class="types">
<?php foreach ($types AS $type) { ?>
    <div class="type">
      <h3><?php echo $this->Html->link($type['Type']['title'], array('action' => 'add', $type['Type']['alias'])); ?></h3>
      <p>
      <div class="info-details"><?php echo $type['Type']['description']; ?></div>
      </p>
    </div>
<?php } ?>
  </div>
</div>
