<html>
<?php 
	echo $this->Html->script('/js/flot/jquery.js');	
	echo $this->Html->script('/js/flot/jquery.flot.js');
	echo $this->Html->script('/js/flot/jquery.flot.categories.js');
	echo $this->Html->script('/js/flot/jquery.flot.pie.js');
?>
<?php echo $this->element('club',array('club'=>$federation));?>
<?php
foreach ($clubs as $club){
	echo $this->element('club',array('club'=>$club['Club']));

}?>
</html>