<table class="divColumn"  width="90%"  cellspacing="20px">
 <tr >
   <td > 
		<div>
          <h3>Les utilisateurs de ce site</h3>
                   <ul class="paddingMedium lineMedium">
                   <li>Les secrétaires de clubs</li>
                   <li>Le secrétaire de la FFC</li>
                   <li>Les membres de clubs</li>
                   </ul>
       
		  <h3>Le secrétaire de club</h3>
                     <ul class="paddingMedium lineMedium">
                     <li>Il enregistre les membres de son club</li>
                     <li>Il peut, mais sans obligation, donner l'accès au site web à ses membres en leur communiquant un nom d'utilisateur et mot de passe temporaires</li>
                     <li>Il valide les demandes de licence introduite par les membres</li>
                     <li>Il a la possibilité d'introduire la demande de licence pour ses membres </li>
                     </ul>

          <h3>Le secrétaire de la fédération</h3>
                     <ul class="paddingMedium lineMedium">
                     <li>Il réceptionne les demandes de licence</li>
                     <li>Il valide les demandes de licence, côntrole la réception du certificat médical pour les licences de compétition</li>
                     <li>Il produit la licence, c-à-d le document, et l'envoie soit directement au membre demandeur soit au secrétaire de club</li>
                     <li>Il clôture la demande de licence et notifie ainsi le demandeur que la licence a été produite et envoyée</li>
                     </ul>
		   
          <h3>Le membre</h3>
                     <ul class="paddingMedium lineMedium">
                     <li>Il demande à son secrétaire de club un nom d'utilisateur et mot de passe temporaires</li>
                     <li>Il valide ou modifie les données encodées par son secrétaire</li>
                     <li>Il a la possibilité d'introduire une demande de production du document de licence</li>
                     </ul>
              
           <h3>Fonctionnalités à venir</h3>
               Ci-dessous quelques idées de ce que ce site pourrait permettre dans le futur:
                     <ul class="paddingMedium lineMedium">
                     <li>Une messagerie disponible pour chaque club qui permettra à chaque membre d'un même club de communiquer</li>
                     <li>Une messagerie pour certains groupes : comités techniques, administrateurs, etc ...</li>
                     <li>Un agenda pour le club géré par les membres du club</li>
                     <li>Un agenda visible par tous géré et accessible par tous les membres</li>
                     <li>Gestion des brevets capacitaires et titres pédagogiques</li>
                     </ul>
               
		</div>
   
   </td>
   <td align="right" valign="top" > 
     	<?php echo $this->Form->create('User',array('controller' => 'users', 'action' => 'login')); ?>
		<div class="login">
            <?php echo $this->Session->flash(); ?>
			<ul>
		      	<li>  <?php  echo $this->Form->input('User.username',array('label' => 'Utilisateur (alias)' )); ?></li>
			    <li> <?php   echo $this->Form->input('User.password',array('label' => 'Mot de passe' ));?></li>
		   </ul>
            <p align="center"><input class="btn-green" type="submit" value="Connection" ></p>
            <br/>
            <p align="right"> <?php //echo $this->Html->link("Me créer un compte","/users/add")  ?></p>
		</div>
		</form>
		
      
   
   </td>
 </tr>
</table>



  
 
 