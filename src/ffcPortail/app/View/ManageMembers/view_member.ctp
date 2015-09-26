<h2>Changer les coordonnées d'un membre</h2>
<?php echo $this->Form->create(null,
array('url'=>'/ManageMembers/editMember/'.$club
)); ?>
<?php echo $this->Form->hidden('User.id');?>
<table width="90%">
   <tr>
      <td><?php echo $this->Form->input('User.nom',array('size'=>'40')); ?></td>
      <td><?php echo $this->Form->input('User.prenom',array('label'=>'Prénom','size'=>'40')); ?></td>
   </tr>
   <tr>
      <td><?php echo $this->Form->input('User.date_naissance', array(
      'label' => 'Date de naissance',
      'dateFormat' => 'DMY',
      'minYear' => date('Y') - 95,
      'maxYear' => date('Y') - 7,
      )); ?></td>
      <td><?php echo $this->Form->input('User.lieu_de_naissance',array('label'=>'Lieu de naissance','size'=>'60'))?></td>
      <td><?php    $options=array('H'=>'Homme','F'=>'Femme'); 
      echo $this->Form->input('User.sexe',array ('options'=> $options,'empty' => true));
      ?></td>
   </tr>
   <tr>
      <td><?php echo $this->Form->input('User.adresse',array('size'=>'50')); ?></td>
      <td><?php echo $this->Form->input('User.code_postal',array('size'=>'5')); ?></td>
      <td><?php echo $this->Form->input('User.ville',array('size'=>'30')); ?></td>
   </tr>
   <tr>
      <td colspan="1"><?php echo $this->Form->input('User.mail',array('size'=>'30')); ?></td>
   </tr>
   <tr>
      <td><?php echo $this->Form->input('User.fixephone', array('label'=>'Téléphone fixe','size'=>'15')); ?>
      </td>
      <td><?php echo $this->Form->input('User.gsm'); ?></td>
   </tr>
</table>
<div><input class="btn-green" type="submit" value="Sauver" /></div>
</form>