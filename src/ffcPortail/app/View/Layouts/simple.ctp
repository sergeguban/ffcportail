<!DOCTYPE html>
<html lang="fr">
<head>
<title>Portail FFC</title>
<!-- styles & scripts -->
<?php
echo $this->Html->css('styleFFC');
echo $this->fetch('css');
?>
</head>
<body>
<!-- header -->
<div class="header"><!-- logo -->
<div class="logo">Portail FFC</div>
<div class="connexion">
  <?php echo $this->Html->link('déconnecter',array('controller'=>'users','action'=>'logout','class'=>'logout')); ?>
  
</div>
<!-- / logo --></div>
<!-- /header -->
<!-- main -->
<div class="main">
<?php echo $this->fetch('content'); ?>
</div>
<!-- /main -->
<!-- footer -->
<div class="footer">
	<div class="footer-copyright">Fédération Francophone de Canoé</div>
</div>

<!-- /footer -->
<div>
<?php echo $this->element('sql_dump');?>
</div>
</body>
</html>
