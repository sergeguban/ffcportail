<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html;charset=UTF-8">
<title>Portail FFC</title>
<!-- styles & scripts -->
<?php
echo $this->Html->css('myStyleFFC');
echo $this->fetch('css');
?>

</head>
<body>
<div class="head">
	<h1>
		<table>
			<tr>
				<td>
					<?php echo $this->Html->image('/_img/ffc_logo.png',array('height'=>60,'width'=>60,'align'=>'middle'));?>
				</td>
				<td>
					<span style='align:bottom'> Portail FFC </span>
				</td>
			</tr>
		</table>
	</h1>
</div>



<div class="main">
<?php 
   echo $this->Session->flash(); 
   echo $this->fetch('content'); 
?>
</div>


<div class="footer"> 
<div class="footer-copyright">Fédération Francophone de Canoé</div>
<div class="footer-version">ffcportail - released @released@ </div>
<?php echo $this->element('sql_dump');?>
</div>
</body>
</html>