

<h2> Gestion des membres du <?php echo $club;?> - <?php echo $currentYear;?> </h2>
<div style="border-color:#fff;border-style:solid;overflow:auto;margin-left:20px;">
<ul class="inline">
<li>
<?php 
		echo $this->Html->link('<div class="icon-share-alt"> </div> Ajouter anciens membres',
                         array('action' => 'old_members_add',$club),
                         array('escape' => false));	
?>
</li>
<li>
<?php 
        echo $this->Html->link('<div class="icon-plus-sign"> </div> Ajouter un nouveau membre',
                         array('action' => 'addMember',$club),
                         array('escape' => false));
        ?>

</li>
<li>
<?php 
        echo $this->Html->link('<div class="icon-upload"> </div> Ajouter une liste de membres',
                         array('action' => 'uploadMembers',$club),
                         array('escape' => false));
        ?>

</li>
<li>
<?php 
        echo $this->Html->link('<div class="icon-download"> </div> Télécharger',
                         array('action' => 'download',$club),
                         array('escape' => false));
        ?>

</li>

</ul>
        
</div>
 <script>
  
   $(function() { 
      
      // call the tablesorter plugin 
      $(".tablesorter").tablesorter({ 
     
        // initialize zebra striping and filter widgets 
        widgets: ["zebra", "filter"], 
     
        headers: { 0: { sorter: false, filter: false } }, 
     
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

<div style="border-color:#ddd;;border-style:solid;margin-left:20px;">
<table class="tablesorter" >
  <thead> 
    <tr> 
     <th class="filter-false" width="10px"></th>
     <th>FFC identifiant</th>
     <th>Nom</th>  <th>Prénom</th> <th>Date naissance</th><th>Lieu de naissance</th><th>Sexe</th><th>Adresse</th><th>Code postal</th><th>Ville</th>
     <th>Mail</th><th>Téléphone fixe</th><th>Gsm</th><th>Date de création</th> 
     <th>Alias/Mot de passe temporaire</th> 
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($members as $member){
  ?>
 
  <tr class="<?php echo $colored?>"  >
  	<td><?php echo $this->Html->link('<div class="icon-zoom-in"> </div>',
                         array('controller' => 'ManageMembers','action' => 'viewMember', $club,$member['User']['id']),
                         array('escape' => false));?></td>
    <td><strong><?php echo $member['User']['ffc_id']?></strong></td>
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
    <td><?php echo  $member['User']['created']?></td>
    <td><?php echo  $member['User']['username_reset']."/".$member['User']['password_reset']  ?></td>
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

</div>
  
  

