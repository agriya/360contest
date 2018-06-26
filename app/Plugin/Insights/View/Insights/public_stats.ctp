<div>
<h3><?php echo __l("Stats");?></h3>
<table class="table table-bordered">
<tr>
  <th> <?php echo __l('Launched Contests');?> </th>
  <th> <?php echo __l('Total').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Successful').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Unsuccessful').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Live').'('.Configure::read('site.currency').')';?> </th>
  <th> <?php echo __l('Live Contests');?> </th>
</tr>
<tr>
  <td> <?php echo $this->Html->cInt($launched_contests);?> </td>
  <td> <?php echo $this->Html->cCurrency($launched_contests_amount[0][0]['launched_contests_amount']);?></td>
  <td> <?php echo $this->Html->cCurrency($successful_contests_amount[0][0]['successful_contests_amount']);?> </td>
  <td> <?php echo $this->Html->cCurrency($unsuccessful_contests_amount[0][0]['unsuccessful_contests_amount']);?> </td>
  <td> <?php echo $this->Html->cCurrency($live_contests_amount[0][0]['live_contests_amount']);?> </td>
  <td> <?php echo $this->Html->cInt($live_contests);?> </td>
</tr>
</table>
</div>
<div>
<h3><?php echo __l('Successfully Entry Contests');?></h3>
<table class="table table-bordered">
<tr>
<th> <?php echo sprintf(__l('Successfully Entry Contests'), Configure::read('project.alt_name_for_project_plural_caps'));?></th>
<?php foreach($pricePoints as $price):?>
  <th><?php echo $price['price_points'].'('.Configure::read('site.currency').')';?></th>
<?php endforeach;?>
</tr>
<tr>
<td> <?php echo $this->Html->cInt($successful_projects);?> </td>
<?php foreach($pricePoints as $price):?>
  <td><?php echo $this->Html->cCurrency($price['creation_cost']);?></td>
<?php endforeach;?>
</tr>
</table>
</div>