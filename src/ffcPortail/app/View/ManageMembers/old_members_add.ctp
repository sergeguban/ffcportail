<script>
  
   $(function() { 
      
      // call the tablesorter plugin 
      $(".tablesorter").tablesorter({ 
     
        // initialize zebra striping and filter widgets 
        widgets: ["zebra", "filter"], 
     
        //headers: { 0: { sorter: false, filter: false } }, 
     
        widgetOptions : { 
     
          // css class applied to the table row containing the filters & the inputs within that row 
          filter_cssFilter : 'tablesorter-filter', 
     
          // filter widget: If there are child rows in the table (rows with class name from "cssChildRow" option) 
          // and this option is true and a match is found anywhere in the child row, then it will make that row 
          // visible; default is false 
          filter_childRows : false, 
     
          // Set this option to true to use the filter to find text from the start of the column 
          // So typing in "a" will find "albert" but not "frank", both have a's; default is false 
          filter_startsWith : false 
     
        } 
     
      }); 
     
    });
   
</script>
<h2> R&eacute;inscrire des anciens membres du <?php echo $club;?> </h2>
<div style="border-color:#ddd;;border-style:solid;margin-left:20px;">
<?php echo $this->Form->create(null, array('url'=> array('controller'=>'ManageMembers',
                                             'action' => 'renew_old',$club)));?>
<table class="tablesorter" >
  <thead> 
    <tr> 
     <th>FFC identifiant</th>
     <th>Nom</th>  <th>Prénom</th> <th>Date naissance</th><th>Lieu de naissance</th><th>Sexe</th><th>Adresse</th><th>Code postal</th><th>Ville</th>
     <th>Mail</th><th>Téléphone fixe</th><th>Gsm</th><th>R&eacute;inscrire </th>
     
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($members as $member){
     	if($member['already_member']==false){
  ?>
 
  <tr class="<?php echo $colored?>"  >
  	<td><strong><?php echo  $member['User']['ffc_id']?></strong></td>
    <td><?php echo  $member['User']['nom']?></td>
    <td><?php echo  $member['User']['prenom']?></td>
    <td><?php echo  $member['User']['date_naissance']?></td>
    <td><?php echo  $member['User']['lieu_de_naissance']?></td>
    <td><?php echo  $member['User']['sexe']?></td>
    <td><?php echo  $member['User']['adresse']?></td>
    <td><?php echo  $member['User']['code_postal']?></td>
    <td><?php echo  $member['User']['ville']?></td>
    <td><?php echo  $member['User']['mail']?></td>
    <td><?php echo  $member['User']['fixephone']?></td>
    <td><?php echo  $member['User']['gsm']?></td>
    <td><?php
   		  echo $this->Form->checkbox('add.'.$member['User']['id']); 
        ?></td>
    </tr>
  
  <?php 
  if ($colored == 'odd'){
      $colored='even';
  } else {
      $colored='odd';
  }
     	}
     }
  ?>
 
</table>
<?php echo $this->Form->submit('Réinscrire membres');?>
<?php $this->Form->end();?>
</div>