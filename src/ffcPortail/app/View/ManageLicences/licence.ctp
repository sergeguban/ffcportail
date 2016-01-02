<h2>Licences <?php echo $currentYear?> à produire </h2>
<p>Vous êtes secrétaire de la FFC</p>
<p>Vous avez à votre charge la production des licences qui sont en demande</p>
<div class="warning">
   Veuillez produire les demandes de licences ci-dessous  !<br/>
   Vérifier que Nom, Prénom, Date et Lieu de naissance sont bien fournis !
</div>
<?php echo $this->Form->create(null, array('url'=> array('controller'=>'ManageLicences',
                                             'action' => 'prepareLicencesProduction'))); ?>
                                             
                                             <script>
  
   $(function() { 
      $(".tablesorter").tablesorter({ 
        widgets: ["zebra", "filter"], 
        widgetOptions : { 
          filter_cssFilter : 'tablesorter-filter'   
        } 
     
      }); 
     
    });
   
   $(function() { 
	      $(".tablesorterReprint").tablesorter({ 
	        widgets: ["zebra", "filter"], 
	        headers: { 8: { sorter: false, filter: false } },
	        widgetOptions : { 
	          filter_cssFilter : 'tablesorter-filter'   
	        } 
	     
	      }); 
	     
	    });
	   
   </script>
<table class="tablesorter">
   <thead>
      <tr>
         <th>Club</th>
         <th>Nom</th>
         <th>Prénom</th>
         <th>Date naissance</th>
         <th>Lieu naissance</th>
         <th>Mail</th>
         <th>Date de la demande</th>
         <th>Discipline</th>
         <th>FFC Identifiant</th>
         <th>A Produire</th>
         <th>Supprimer</th>
      </tr>
   </thead>
   <?php
   $colored='odd';
   foreach ($licencesValider as $licenceValider){

   	?>
   <tr class="<?php echo $colored?>">
      <td><?php echo $licenceValider['Membership']['club']?></td>
      <td><?php echo $licenceValider['User']['nom']?></td>
      <td><?php echo $licenceValider['User']['prenom']?></td>
      <td><?php echo $licenceValider['User']['date_naissance']?></td>
      <td><?php echo $licenceValider['User']['lieu_de_naissance']?></td>
      <td><?php echo $licenceValider['User']['mail']?></td>
      <td><?php echo $licenceValider['Membership']['l_created']?></td>
      <td><?php echo AppController::getLicenceString($licenceValider['Membership'])?></td>
      <td><?php echo $licenceValider['User']['ffc_id']?></td>
      <td>
       <?php if($licenceValider['User']['ffc_id'] != null) { 
       			echo $this->Form->checkbox($licenceValider['Membership']['id']);
            } else {
       		?>
            <strong>nouveau membre à valider</strong>
        <?php }?>
        
        </td>
        <td><?php 
        $image = $this->Html->image('remove.gif', array('width' => '15px'));  
        echo $this->Html->link($image,
                         array('controller' => 'ManageLicences','action' => 'supprimerDemande', $licenceValider['Membership']['id']),
                         array('escape' => false));
        ?></td>
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
   <?php
   echo $this->Form->submit('Produire Licences');
   echo $this->Form->end();

   ?>
   <?php
   if ($this->Session->check('licencesToProduceCsv')) {

    echo $this->Form->create('licenceProduction', array('url'=> array('controller'=>'ManageLicences',
                                                'action' => 'produceLicences'))); 
    echo $this->Form->submit("Télécharger le PDF",array("class"=>"submitError") );
    echo $this->Form->end();
   }

   ?>
<h2>Licences  <?php echo $currentYear?> produites</h2>
<p>Ci-dessous la liste des licences déjà produites et envoyées</p>
<table class="tablesorterReprint">
   <thead>
      <tr>
         <th>Club</th>
         <th>Nom</th>
         <th>Prénom</th>
         <th>Mail</th>
         <th>Date de la demande</th>
         <th>Date de production</th>
         <th>Discipline</th>
         <th>Numéro</th>
         <th>Reprint</th>
      </tr>
   </thead>
   <?php
   $colored='odd';
   foreach ($licencesProduced as $licenceProduced){

   	?>
   <tr class="<?php echo $colored?>">
      <td><?php echo  $licenceProduced['Membership']['club']?></td>
      <td><?php echo  $licenceProduced['User']['nom']?></td>
      <td><?php echo  $licenceProduced['User']['prenom']?></td>
      <td><?php echo $licenceProduced['User']['mail']?></td>
      <td><?php echo $licenceProduced['Membership']['l_created']?></td>
      <td><?php echo $licenceProduced['Membership']['l_modified']?></td>
      <td><?php echo AppController::getLicenceString($licenceProduced['Membership'])?></td>
      <td><?php echo $licenceProduced['User']['ffc_id']."/".$licenceProduced['Membership']['l_yearly_number']?></td>
      <td><?php echo $this->Html->link('<div class="icon-print"> </div>',
      array('controller' => 'manageLicences','action' => 'reproduceLicence',  $licenceProduced['Membership']['id']),
      array('escape' => false));?>
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
