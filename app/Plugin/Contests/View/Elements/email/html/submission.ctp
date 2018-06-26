<h2>New "<?php echo $response['Cform']['name'];?>" Submission</h2>
<strong>Submitted On</strong> <?php echo date('m/d/y \a\t h:i A');?><br />
<strong>Page:</strong> <?php echo $response['Submission']['page'];?><br />
<strong>IP:</strong> <?php echo long2ip($response['Submission']['ip']);?><br />

=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
<table>
<?php foreach($response['Form'] as $label => $data):?>
<?php
    $style = '';
    if(strstr($label, 'fs_')){
    $style = 'style="background:#ececec"';
    $label = $data;
    $data = null;
    }
    if(is_array($data)){
        $data = implode(', ', $data);
    }
    ?>
<tr <?php echo $style;?>><td style="width:120px; padding-right: 10px; text-align: right"><strong><?php echo Inflector::humanize($label);?></strong></td><td style="width:450px"><?php echo $data;?></td></tr>
<?php endforeach;?>
</table>