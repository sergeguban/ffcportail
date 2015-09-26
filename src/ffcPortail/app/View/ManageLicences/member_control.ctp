<h2>Contrôle du nouveau membre</h2>
<h3>Données du membre</h3>
<?php 
     echo $this->element('member',array("user"=>$newUser,"newUser"=>0));
?>

<div class="warning">
Vous devez valider le nouveau membre. <br/>
Il est possible que ce nouveau membre soit déjà présent dans la base de données.<br/>
Les liste de doublons plus bas sont là pour vous aider à vérifier cela.<br/>
Lorsque vous validez un membre, il se voit attribué automatiquement un identifiant unique.<br/>
Si vous le retirer, il est tout simplement effac&eacute; de la base de données.
</div>

<?php 

	if($newUser['username'] != null){
?>
<div class="warning">
Ce membre a déjà activé son compte !
</div>
<?php }?>

<div>

<table width="100%" >
<tr valign="bottom">
<td>
<?php 


	echo $this->Form->create(null, array('url'=> array('controller'=>'ManageLicences',
                                             'action' => 'validateNewMember'))); 
	
	echo $this->Form->hidden('User.id',array("value"=>$newUser['id']));
    
	echo $this->Form->submit('Valider');
	echo $this->Form->end();
	
	?>
   </td>
   <td align="right">
   
	<?php 
	
	
	echo $this->Form->create(null, array('url'=> array('controller'=>'ManageLicences',
                                             'action' => 'deleteNewMember'))); 
	
	echo $this->Form->hidden('User.id',array("value"=>$newUser['id']));
	echo $this->Form->submit('Retirer ce membre definitivement',array('class'=>'submitError'));
	echo $this->Form->end();
	
?>
   </td>
</tr>
</table>

</div>
<h3>Liste des doublons très probable (nom et prénom identiques)</h3>
<?php 
	foreach ($strongDuplicates as $member) {
		 echo $this->element('member',array("user"=>$member['users'],"newUser"=>$newUser['id']));
	}
?>
<h3>Liste des doublons possible (nom ou prénom identiques)</h3>
<?php 
   foreach ($duplicates as $member) {
       echo $this->element('member',array("user"=>$member['users'],"newUser"=>$newUser['id']));
   }
?>

