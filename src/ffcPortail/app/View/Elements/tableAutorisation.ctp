
<h3><?php echo $tableTitle?></h3>
<table class="list">
  <thead> 
    <tr> 
      <th>Nom</th>  <th>Prénom</th> <th>Club</th><th>Révoquer</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($rows as $row){
  
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $row['User']['nom']?></td>
    <td><?php echo  $row['User']['prenom']?></td>
    <td><?php echo  ($group=='clubSecretaire')?$row['Membership']['club']:$row['User']['club']?></td>
    <td><?php 
        $image = $this->Html->image('remove.gif', array('alt' => ''));  
        echo $this->Html->link($image,
                         array('controller' => 'Autorisation','action' => 'revoke',  ($group=='clubSecretaire')?$row['Membership']['id']:$row['User']['id'], $group),
                         array('escape' => false));
        ?>
    </td>
  </tr>
  
  <?php 
  if ($colored == 'odd'){
      $colored='even';
  } else {
      $colored='odd';
  }
  
     }
  ?>
</table>
