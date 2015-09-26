<script type="text/javascript">
$(function() { 
    $("table").tablesorter({ 
      widgets: ["zebra", "filter"], 
      widgetOptions : { 
        filter_cssFilter : 'tablesorter-filter'   
      } 
   
    }); 
   
  });
</script>
<h2>Tous les membres</h2>
<table class="list">
	<thead>
		<tr>
		<th>Year</th><th>FFC ID</th><th>Nom</th><th>Pr&eacute;nom</th><th>Club</th><th>Secr&eacute;taire</th><th>Prolonger</th><th>Licence</th><th>Retirer</th><th>Alias/Mot de Passe</th>
		</tr>
	</thead>
	<?php 
	$colored='odd';
	foreach($members as $member){?>
	
	<?php 
		$td_lic='';
		if($member['Membership']['licence']==1){
			$td_lic=$member['Membership']['l_type'].' '.$member['Membership']['l_status'].' '.$this->Html->link('<div class="icon-remove"> </div>',
                         array('action' => 'delete_licence',$member['Membership']['id']),
                         array('escape' => false));
		}
		else if($member['Membership']['year']==date('Y')){
			$td_lic=$this->Html->link('<div class="icon-plus-sign"> </div>Comp&eacute;tition',array('action'=>'new_licence',$member['Membership']['id'],'Competition'),array('escape'=>false)).
					' '.
					$this->Html->link('<div class="icon-plus-sign"> </div>Tourisme',array('action'=>'new_licence',$member['Membership']['id'],'Tourisme'),array('escape'=>false));
		}
		else $td_lic='pas de licence';
	
	?>
		<tr>
			<td><?php echo $member['Membership']['year']?></td>
			<td><?php echo $member['User']['ffc_id']?></td>
			<td><?php echo $member['User']['nom']?></td>
			<td><?php echo $member['User']['prenom']?></td>
			<td width=10px align="center"><?php echo $member['Membership']['club']?></td>
			<td width=10px align="center"><?php echo $member['Membership']['is_secretary']?'oui':'non';?></td>
			<td width=10px align="center"><?php if($member['Membership']['is_currently_member']==false){echo $this->Html->link('<div class="icon-share-alt"> </div>',
                         array('action' => 'add_old_member',$member['Membership']['id']),
                         array('escape' => false));}else{echo 'd&eacute;j&agrave; fait';}?></td>
            <td><?php echo $td_lic?></td>
            <td width=10px align="center"><?php echo $this->Html->link('<div class="icon-remove"></div>',
            			array('action'=>'remove_member',$member['Membership']['id']),
            			array('escape'=>false));?></td>
            <td><?php echo $member['User']['username_reset'].'/'.$member['User']['password_reset']?></td>
            			
			
		</tr>
	<?php 
	if ($colored == 'odd'){
      $colored='even';
  	} else {
      $colored='odd';
  	}
	}?>
	
</table>
