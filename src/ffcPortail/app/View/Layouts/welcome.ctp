<!DOCTYPE html>
<html lang="fr">
<head>
<title>Portail FFC</title>
<!-- styles & scripts -->
<?php
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('styles');
		echo $this->fetch('css');

		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('jquery.dataTables');
		echo $this->Html->script('jquery.datepicker');
		echo $this->Html->script('jquery.tinyscrollbar.min');
		echo $this->fetch('script');
		
		?>
<!--[if lt IE 9]>
<?php 
		echo $this->Html->script('jquery.corner');
		echo $this->Html->script('respond.min');
		echo $this->fetch('script');
?>
<![endif]--> 

<?php 
	echo $this->Html->script('script');
	echo $this->fetch('script');
?>
</head>
<body class="normal">
<!-- header -->
<div class="container-fluid" id="header">


 <!-- logo -->
  <div class="row-fluid" id="header-logo">
    <div class="span10 logo">Portail FFC </div>
 
  </div>
  <!-- / logo -->
  
   
</div>
<!-- /header --> 
<!-- main -->
<div class="container-fluid" id="main">
  <div class="row-fluid" id="select-patient">
    <div class="span5">
      <div id="scrollbar">
        <div class="scrollbar">
          <div class="track">
            <div class="thumb">
              <div class="end"></div>
            </div>
          </div>
        </div>
        <div class="viewport">
          <div class="overview">
            <h3>Ce site pourquoi</h3>
            TODO Expliquer ici à quoi sert ce site. 
             <ul>
             <li>Gestion des licences</li>
             <li>Permettre au pratiquant d'introduire une demande de licence</li>
             <li>Permettre au délégué de club de valider la demande de licence et de la notifier au secrétaire de la fédé</li>
             <li>Permettre au secrétaire de la fédé de créer une licence, d'attribuer un numéro,  de notifier le pratiquant de la création de sa licence</li>
             <li>Permettre à un arbitre de controler la licence d'un compétiteur</li>
             <li>Permettre à un gestionnaire de la fédération de tirer des statistiques</li>
             </ul>
        
            <h3>Procédure d'enregistrement</h3>
             TODO Expliquer comment on se crée un compte et comment on introduit une demande de licence  
             <ul>
             <li>Remplir et envoyer le formulaire d'enregistrement via le bouton "Créer un compte"</li>
             <li>Votre demande d'enregistrement doit être validé par votre délégué de club qui vérifie que vous êtes en ordre de cotisation</li>
             <li>Vous recevrez un mail vous notifiant que votre enregistrement a été valider</li>
             <li>Le secrétaire de la fédération reprend périodiquement les demandes de licences, il les valide et vous envois le précieux document de licence</li>
             <li>Vous pouvez vous connecter pour vérifier l'état d'avancement de votre licence</li>
             </ul>
         </div>
        </div>
      </div>
    </div>
   			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
   
</div>
<!-- /main --> 
<!-- footer -->
<div class="container-fluid" id="footer">
  <div class="row-fluid">
    <div class="span12">
      <div class="footer-copyright">Fédération Francophone de Canoé</div>
    </div>
  </div>
</div>
<!-- /footer --> 
</body>
</html>
