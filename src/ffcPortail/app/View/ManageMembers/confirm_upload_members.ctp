<h2>Confirmer l'enregistrement de la liste de membres</h2>
<table class="list">
  <tr>
    <th>Status</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Date naissance</th>
    <th>Lieu de naissance</th>
    <th>Sexe</th>
    <th>Adresse</th>
    <th>Code postal</th>
    <th>Ville</th>
    <th>Mail</th>
    <th>Téléphone fixe</th>
    <th>Gsm</th>
    <th>Club</th>
    
   </tr>
  
  
		  <?php 
		  $rowClass="even"; 
		  foreach ($users as $user){
		  if ($rowClass == "even") $rowClass="odd";   
		     
		?>     
		  <tr class="<?php echo $rowClass; ?>">
		    <?php echo $this->FieldError->checkField($user); ?> 
            <?php echo $this->FieldError->display($user,'nom');  ?>
            <?php echo $this->FieldError->display($user,'prenom'); ?>
            <?php echo $this->FieldError->display($user,'date_naissance'); ?>
            <?php echo $this->FieldError->display($user,'lieu_de_naissance');?>
            <?php echo $this->FieldError->display($user,'sexe'); ?>
            <?php echo $this->FieldError->display($user,'adresse'); ?>
            <?php echo $this->FieldError->display($user,'code_postal'); ?>
            <?php echo $this->FieldError->display($user,'ville'); ?>
            <?php echo $this->FieldError->display($user,'mail'); ?>
            <?php echo $this->FieldError->display($user,'fixephone'); ?>
            <?php echo $this->FieldError->display($user,'gsm'); ?>
            <?php echo $this->FieldError->display($user,'club'); ?>
         </tr>
		<?php 
		  }
?>     
</table>


<table >
  <tr>
    <td>
	<?php 
	if ($isValid) {
		echo $this->Form->create(null,
		array('url'=>'/ManageMembers/confirmUploadMembers/'.$club
		)); ?>
	    <?php 
		      echo $this->Form->hidden("members",array("value"=>$membersCsv));
		      echo $this->Form->hidden("club",array("value"=>$clubSelected));
		      ?>
		<div><input class="btn-green" type="submit" value="Confirmer" /></div>
        </form>
	<?php 
	} 
	?>
    </td>
    <td >
    
	<?php 
	   echo $this->Form->create(null,
	   array('url'=>'/ManageMembers/uploadMembers/'.$club.'/retry'
	   )); ?>
	    <?php 
	         echo $this->Form->hidden("members",array("value"=>$membersCsv));
	     ?>
	   <div><input class="btn-green" type="submit" value="Corriger" /></div>
       </form>
    </td>
  </tr>
</table>




</form>
