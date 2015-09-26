<table width="90%" class="form">
   <tr>
      <td colspan="1"><strong>FFC ID : </strong> <?php echo $user['ffc_id']; ?></td>
      <td colspan="1"><strong>Club : </strong><?php echo $user['club'];?></td>
   </tr>
   
   <tr>
      <td><strong>Nom : </strong> <?php echo  $user['nom']; ?></td>
      <td><strong>Prénom : </strong><?php echo   $user['prenom'];  ?></td>
      <td><strong>Date de naissance : </strong> <?php echo   $user['date_naissance']; ?></td>
      <td><strong>Sexe : </strong> <?php echo   $user['sexe']; ?></td>
   </tr> 
   <tr>
      <td><strong>Adresse :  </strong> <?php echo  $user['adresse']; ?></td>
      <td><strong>Code Postal : </strong><?php echo  $user['code_postal']; ?></td>
      <td><strong>Ville :  </strong><?php echo   $user['ville']; ?></td>
   </tr>
   <tr>
      <td colspan="1"><strong>Mail : </strong> <?php echo $user['mail']; ?></td>
   </tr>
   <tr>
      <td><strong>Tel Fixe : </strong><?php echo $user['fixephone']; ?></td>
      <td><strong>Gsm : </strong> <?php echo $user['gsm']; ?></td>
      <?php if($newUser!=0){?>
      <td align="right" colspan="2">
      	<?php 
      	echo $this->Form->create(null, array('url'=> array('controller'=>'ManageLicences',
                                             'action' => 'replaceMember'))); 
	
		echo $this->Form->hidden('User.new_id',array("value"=>$newUser));
		echo $this->Form->hidden('User.old_id',array("value"=>$user['id']));
		echo $this->Form->submit('Est doublon',array('class'=>'submitError'));
		echo $this->Form->end();
		?>
      </td>
      <?php }?>
   </tr>
</table>
