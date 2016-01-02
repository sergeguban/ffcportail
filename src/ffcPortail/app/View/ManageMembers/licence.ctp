<?php App::import('Controller', 'App');?>
<script type="text/javascript">
//<!--
$(function() { 
    $("table").tablesorter({ 
      widgets: ["zebra", "filter"], 
   //   headers: { 8: { sorter: false, filter: false } },
      widgetOptions : { 
        filter_cssFilter : 'tablesorter-filter'   
      } 
   
    }); 
   
  });

//-->
</script>
<h2>Introduire une demande de licence pour un de vos membres</h2>
Vos membres ont la possibilité d'introduire eux-même une demande de licence.
Cependant vous pouvez introduire la demande à leur place.
Sélectionner ci-dessous un membre pour qui vous désirez introduire une demande de licence.

<?php echo $this->Form->create(null, array('url'=> array('controller'=>'Licences',
                                             'action' => 'requestAndValidateLicences',$club)));?>


<table class="list">
  <thead> 
    <tr> 
     <th>Tourisme</th><th>Compétition Générale</th><th>Descente</th><th>Slalom</th><th>Course en Ligne</th><th>Marathon</th><th>Kayak-Polo</th><th>Nom</th>  <th>Prénom</th> <th>Date naissance</th><th>Sexe</th><th>Adresse</th><th>Code postal</th><th>Ville</th>
    </tr> 
 </thead>
 
 
  <?php
      
     $colored='odd';
     foreach ($members as $member){
     	$alreadyAsked=in_array($member['User']['id'],$licencesAlreadyAsked)?'asked':'notAsked';
  ?>
 
  <tr class="<?php echo "$colored  $alreadyAsked"?>"  >
   <?php if($alreadyAsked=='asked'){?>
   <td colspan=7 align="center"> Demande faite</td>
   <?php }else{?>
   <td> <?php
   		  	echo $this->Form->checkbox('tourism.'.$member['Membership']['id']); 
        ?>
        
    </td>
   <td> <?php
   		  echo $this->Form->checkbox('competition.'.$member['Membership']['id']); 
        ?>
        
    </td>
    <td> <?php
   		  echo $this->Form->checkbox('downriver.'.$member['Membership']['id']); 
        ?>
        
    </td>
    <td> <?php
   		  echo $this->Form->checkbox('slalom.'.$member['Membership']['id']); 
        ?>
        
    </td>
    <td> <?php
   		  echo $this->Form->checkbox('flatwater.'.$member['Membership']['id']); 
        ?>
        
    </td>
    <td> <?php
   		  echo $this->Form->checkbox('marathon.'.$member['Membership']['id']); 
        ?>
    </td>
    <td> <?php
   		  echo $this->Form->checkbox('polo.'.$member['Membership']['id']); 
        ?>    
    </td><?php }?>
    <td><?php echo  $member['User']['nom']?></td>
    <td><?php echo  $member['User']['prenom']?></td>
    <td><?php echo  $member['User']['date_naissance']?></td>
    <td><?php echo  $member['User']['sexe']?></td>
    <td><?php echo  $member['User']['adresse']?></td>
    <td><?php echo  $member['User']['code_postal']?></td>
    <td><?php echo  $member['User']['ville']?></td>
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



<?php echo $this->Form->submit('Demande et validation des licences')?>
</form>
<h2>Valider les demandes de licences <?php echo $currentYear?> de votre club</h2>

<p>Vous êtes délégué de club.</p>
<p>Votre rôle est de valider les nouvelles demandes de licence, pour se faire vous devez controler les données du membre et vérifier qu'il est en règle de cotisation pour l'année en cours au sein de votre club.</p>


<?php 
if ($licencesAValider != null){
  ?> 
  <div class="warning"> Veuillez valider les demandes de licences ci-dessous ! </div>
  <?php  
} else {
   
}
?>

<table class="list">
  <thead> 
    <tr> 
      <th>Nom</th>  <th>Prénom</th> <th>Mail</th>  <th>Date de la demande</th><th>Discipline</th><th>Valider</th><th>Refuser</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($licencesAValider as $licenceAValider){
  
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $licenceAValider['User']['nom']?></td>
    <td><?php echo  $licenceAValider['User']['prenom']?></td>
    <td><?php echo $licenceAValider['User']['mail']?></td>
    <td><?php echo $licenceAValider['Membership']['l_created']?></td>
    <td><?php echo AppController::getLicenceString($licenceAValider['Membership'])?></td>
    <td><?php 
        echo $this->Html->link('<div class="icon-ok-sign"> </div>',
                         array('controller' => 'licences','action' => 'valider',  $club,$licenceAValider['Membership']['id']),
                         array('escape' => false));
        ?>
    </td>
     <td><?php 
        echo $this->Html->link('<div class="icon-remove-sign"> </div>',
                         array('controller' => 'licences','action' => 'refuser',  $club,$licenceAValider['Membership']['id']),
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


<h2>Licences <?php echo $currentYear?> en production</h2>

<p>Ci-dessous la liste des demandes de licences qui sont en cours de production chez le secrétaire fédéral.</p>


<table class="list">
  <thead> 
    <tr> 
      <th>Nom</th>  <th>Prénom</th> <th>Mail</th>  <th>Date de la demande</th><th>Discipline</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($licencesValider as $licenceValider){
  
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $licenceValider['User']['nom']?></td>
    <td><?php echo  $licenceValider['User']['prenom']?></td>
    <td><?php echo $licenceValider['User']['mail']?></td>
    <td><?php echo $licenceValider['Membership']['l_created']?></td>
        <td><?php echo AppController::getLicenceString($licenceValider['Membership'])?></td>
    
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

  
<h2>Licences <?php echo $currentYear?> produites</h2>

<p>Ci-dessous la liste des licences <?php echo $currentYear?> produites et envoyées par le secrétaire fédéral.</p>


<table class="tablesorter">
  <thead> 
    <tr> 
      <th class="filter-false" width="10px"></th>
      <th>Nom</th>  <th>Prénom</th> <th>Mail</th>  <th>Date de la demande</th>
      <th>Date d'envois</th><th>Discipline</th><th>N° Licence</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($licencesProduced as $licenceProduced){
  
  ?>
 
  <tr class="<?php echo $colored?>">
     <td><?php echo $this->Html->link('<div class="icon-print"> </div>',
      array('controller' => 'manageLicences','action' => 'reproduceLicence',  $licenceProduced['Membership']['id']),
      array('escape' => false));?>
      </td>
    <td><?php echo  $licenceProduced['User']['nom']?></td>
    <td><?php echo  $licenceProduced['User']['prenom']?></td>
    <td><?php echo $licenceProduced['User']['mail']?></td>
    <td><?php echo $licenceProduced['Membership']['l_created']?></td>
    <td><?php echo $licenceProduced['Membership']['l_modified']?></td>
    <td><?php echo AppController::getLicenceString($licenceProduced['Membership'])?></td>
    
    <td><?php echo  $licenceProduced['User']['ffc_id'] . '/' . $licenceProduced['Membership']['l_yearly_number']?></td>
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



