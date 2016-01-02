
<div class="">
<ul class="unstyled inline border">
   <li><strong>Nom utilisateur(alias)</strong> <?php echo $this->data['User']['username']; ?></li>
   <li><strong>Nom</strong> <?php echo $this->data['User']['nom']; ?></li>
   <li><strong>Prénom</strong> <?php echo $this->data['User']['prenom']; ?></li>
   <li><strong>Date de naissance</strong> <?php echo $this->data['User']['date_naissance']; ?></li>
   <li><strong>Sexe</strong> <?php echo $this->data['User']['sexe']; ?></li>
   <?php if($this->data['User']['ffc_id'] !=null){?>
   <li><strong>Identifiant</strong> <?php echo $this->data['User']['ffc_id']?></li>
   <?php }?>
</ul>
</div>
<h2>Vos données</h2>
<?php echo $this->Form->create('User',array(
                                          'controler'=>'User',
                                          'action' => 'edit' 
                                          )); ?>
<table width="90%" class="form">
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
   <tr>
      <td colspan="3" align="right"><input class="btn-green" type="submit" value="Sauver" /></td>
   </tr>
</table>
</form>
<h2>Changer votre mot de passe</h2>
                                          <?php   if($this->data['User']['username'] == null){?>
<div class="message">Vous avez un compte temporaire, vous devez définir votre alias et mot de passe
!</div>
                                          <?php   } ?>
                                          <?php echo $this->Form->create('User',array(
                                          'controler'=>'User',
                                          'action' => 'saveNewPassword' 
                                          )); ?>
<table width="90%" class="form">
   <tr>
      <td><?php echo $this->Form->input('User.username',array('label'=>'Alias')); ?></td>
      <td><?php echo $this->Form->input('User.password',array('label'=>'Mot de passe')); ?></td>
      <td><?php echo $this->Form->input('User.repeatPassword',array('label'=>'Répéter Mot de passe','type'=>'password')); ?>
      </td>
   </tr>
   <tr>
      <td colspan="3" align="right"><input class="btn-green" type="submit" value="Sauver" /></td>
   </tr>
</table>
</form>

<h2>Brevets et titres pédagogiques</h2>
<div style="margin:20px">
 TODO
<ul>
   <li>Permettre de notifier la possession d'un titre pédagogique</li>
   <li>Permettre de gérér ses brevets, d'introduire une demande de passage de brevet</li>
</ul>
</div>



<h2>Licence</h2>
<?php 

foreach($memberships as $membership){?>
	<h3><?php echo $membership['Membership']['club'];?></h3>
	<?php if($membership['Membership']['licence']!=1){?>
		<div class="warning">Vous n'avez pas de licence pour l'année <?php echo $currentYear;?> pour le club <?php echo $membership['Membership']['club']?>!</div>
                                          <?php echo $this->Form->create('Licence',
                                          array('controller'=>'Licence',
                                  'action' => 'add',
                                  'url'=>array($membership['Membership']['club']),
                                  'inputDefaults' => array('label' => false,
                                                           'div'   => false,
                                                           'error' => array('wrap'  => 'span', 
                                                                            'class' => 'my-error-class')
                                          )
                                          
                                          )); ?>
<table width="90%" class="form">
   <tr>
      <td>Type de Licence</td>
    
   </tr>
   <tr>
      <td><?php
      echo $this->Form->input( 'id'.$membership['Membership']['club'], array( 'value' => $membership['Membership']['id'],'type'=>'hidden') );  
      $options=array('Competition'=>'Compétition','Tourisme'=>'Tourisme');
      $attributes=array('legend'=>false);
      echo $this->Form->radio('type'.$membership['Membership']['club'],$options,$attributes);
      ?>
      </td>
   </tr>
   <tr>
      <td colspan="2" align="right"><input class="btn-green" type="submit"
         value="Envoyer ma demande de licence"
      /></td>
   </tr>
</table>

<?php echo $this->Form->end();?>
	<?php }else if ($membership['Membership']['l_status'] == 'requested') { ?>
<div class="warning">Votre demande de licence <?php echo $currentYear?> est en cours de validation !</div>
                                          <?php }  else if ($membership['Membership']['l_status'] == 'validated') { ?>
<div class="warning">Votre demande de licence <?php echo  $currentYear?> a été validée, elle vous sera bientôt envoyé !</div>
                                          <?php }  else if ($membership['Membership']['l_status'] == 'produced') { ?>
<div class="warning">Votre demande de licence <?php echo $currentYear?> a été produite et envoyée le <?php echo $membership['Membership']['l_modified']?>
!
<br/>

Votre numéro de licence : <strong> <?php echo $this->data['User']['ffc_id'].'/'.  $membership['Membership']['l_yearly_number']?></strong> 
</div>



                                          <?php }?>

	
	
	


<?php }?>
<h2>Demandes d'autorisation</h2>
Chaque utilisateur de ce site peut se voir attribuer un ou plusieurs rôles, en fonction de son rôle effectif au sein de son club ou de la FFC.<br/>
Si par exemple vous êtes secrétaire sportif de votre club, à savoir que vous êtes en charge de valider les demandes de licence des membres de votre club, vous pouvez introduire ci-dessous une demande d’autorisation pour vous voir assigner le rôle correspondant.<br/>
Idem si vous occupez des fonctions d’arbitre ou de secrétariat à la FFC.<br/>
Il va de soi que tout rôle demandé ne sera attribué qu’après vérification par l'administrateur de ce site de votre fonction réelle dans votre club ou la FFC.<br/>
Une fois un rôle obtenu, vous aurez accès aux menus et fonctions correspondant à ce role.<br/>                                         
  <?php echo $this->Form->create(null, array('url'=> array('controller'=>'Notifications',
                                             'action' => 'addAutorisationRequest'))
                                          );

$isSubmitButtonDisplayed = false;
?>
<table width="90%" class="form" cellspacing="12px" >
   <?php foreach($memberships as $membership){?>
   			<tr>
    		<?php if($membership['Membership']['is_secretary']==1){
    			?><td></td><td valign="top"> Vous avez le rôle de secrétaire de club <strong><?php echo $membership['Membership']['club']?></strong></td> 
    			<?php 
    		}else if(in_array($membership['Membership']['club'],$notificationsWaitList['clubSecretaire'])){
    			?><td></td><td valign="top"> Votre demande de rôle de secrétaire de club <strong><?php echo $membership['Membership']['club']?></strong> est en cours de validation </td>
    			<?php
    		}else{
    			?><td> <?php echo $this->Form->checkbox('clubSecretaire.'.$membership['Membership']['club']); $isSubmitButtonDisplayed=true;?> </td><td valign="top">Je souhaite qu'on m'ajoute le rôle de secrétaire de club <strong><?php echo $membership['Membership']['club']?></strong></td>
    			<?php
    		}?></tr>
    	<?php }?>
    
   <tr>
      
   		<?php if(in_array ('admin',$roles)){      ?> <td></td><td valign="top">Vous avez le rôle d'administrateur</td>  <?php } else 
      	      if($notificationsWaitList['admin']==true){ ?><td></td><td valign="top"> Votre demande de rôle administrateur est en cours de validation </td> <?php } else 
   		          {?><td> <?php  echo $this->Form->checkbox('admin');$isSubmitButtonDisplayed=true; ?> </td><td valign="top">Je souhaite qu'on m'ajoute le rôle administrateur </td> <?php } ?>
      
   </tr>
   
   <tr>
         <?php if(in_array ('federalSecretaire',$roles)){      ?><td></td><td valign="top"> Vous avez le rôle de secrétaire de la fédération </td> <?php } else 
               if($notificationsWaitList['federalSecretaire']==true){ ?> <td></td><td valign="top">Votre demande de rôle de secrétaire de la fédération est en cours de validation </td> <?php } else 
                   {?><td> <?php echo $this->Form->checkbox('federalSecretaire'); $isSubmitButtonDisplayed=true;?></td><td valign="top">Je souhaite qu'on m'ajoute le rôle de secrétaire de la fédération</td> <?php } ?>
   </tr>
  <tr>
         <?php if(in_array ('arbitre',$roles)){      ?><td></td><td valign="top"> Vous avez le rôle d'arbitre </td> <?php } else 
               if($notificationsWaitList['arbitre']==true){ ?><td></td><td valign="top"> Votre demande de rôle d'arbitre est en cours de validation </td> <?php } else 
                   {?><td> <?php echo $this->Form->checkbox('arbitre');$isSubmitButtonDisplayed=true; ?></td><td valign="top"> Je souhaite qu'on m'ajoute le rôle d'arbitre </td> <?php } ?>
   </tr>
   <?php if($isSubmitButtonDisplayed){?>
   <tr>
      <td colspan="2" align="right"><input class="btn-green" type="submit"
         value="Enregistrer ma demande"
      /></td>
   </tr>
   <?php }?>
</table>
<?php   echo $this->Form->end()?>