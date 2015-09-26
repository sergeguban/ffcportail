<script type="text/javascript">
<!--
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
<h2>Demandes d'autorisation</h2>
<table class="list">
  <thead> 
    <tr> 
      <th>Nom</th><th>Prénom</th><th>Club</th><th>Demande</th> <th>Date de la demande</th><th>Valider</th><th>Refuser</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($autorisationsRequest as $autorisationRequest){
  
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $autorisationRequest['User']['nom']?></td>
    <td><?php echo  $autorisationRequest['User']['prenom']?></td>
    <td><?php echo  $autorisationRequest['Notification']['comment']?></td>
    <td><?php echo $autorisationRequest['Notification']['request']?></td>
    <td><?php echo $autorisationRequest['Notification']['created']?></td>
    <td><?php 
        $image = $this->Html->image('ok.ico', array('width' => '15px'));  
        echo $this->Html->link($image,
                         array('controller' => 'Autorisation','action' => 'valider', $autorisationRequest['Notification']['id']),
                         array('escape' => false));
        ?>
    </td>
    <td><?php 
        $image = $this->Html->image('remove.gif', array('width' => '15px'));  
        echo $this->Html->link($image,
                         array('controller' => 'Autorisation','action' => 'refuser', $autorisationRequest['Notification']['id']),
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

<?php 
  echo $this->element('tableAutorisation',array("rows"=>$admins,'tableTitle'=>'Les administrateurs','group'=>'admin'));
?>
<?php 
  echo $this->element('tableAutorisation',array("rows"=>$federalSecretaires,'tableTitle'=>'Les secrétaires de la fédération','group'=>'federalSecretaire'));
?>
<?php 
  echo $this->element('tableAutorisation',array("rows"=>$clubSecretaires,'tableTitle'=>'Les secrétaires de club','group'=>'clubSecretaire'));
?>
<?php 
  echo $this->element('tableAutorisation',array("rows"=>$arbitres,'tableTitle'=>'Les arbitres','group'=>'arbitre'));
?>
  
  
  
  