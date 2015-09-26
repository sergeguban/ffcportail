<h2>Nouveaux Membres</h2>

<p>Vous êtes secrétaire de la FFC</p>
<p>Vous avez à votre charge la validation de l'ajout de nouveaux membres</p>

<div class="warning">
 Voir le détail du nouveau membre en cliquant sur la loupe dans la colonne de gauche pour valider son entré dans la base de données
 </div>


<table class="list">
  <thead> 
    <tr> 
      <th></th><th>Club</th>  <th>Nom</th>  <th>Prénom</th>  <th>Date Naissance</th> <th>Mail</th>   <th>FFC ID</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($newUsers as $newUser){
  
  ?>
 
    <tr class="<?php echo $colored?>">
    <td><?php echo $this->Html->link('<div class="icon-zoom-in"> </div>',
                         array('controller' => 'ManageLicences','action' => 'memberControl',  $newUser['users']['id']),
                         array('escape' => false));?>
    <td><?php echo $newUser['users']['club']?></td>
    <td><?php echo $newUser['users']['nom']?></td>
    <td><?php echo $newUser['users']['prenom']?></td>
    <td><?php echo $newUser['users']['date_naissance']?></td>
    <td><?php echo $newUser['users']['mail']?></td>
    <td><?php echo $newUser['users']['ffc_id']?></td>
    
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



