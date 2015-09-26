<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html;charset=UTF-8">
<title>Portail FFC</title>
<!-- styles & scripts -->
<?php
echo $this->Html->css('myStyleFFC');
echo $this->Html->css('styles');
echo $this->Html->css('icon');
echo $this->Html->css('messages');
echo $this->Html->css('theme.default');
echo $this->fetch('css');
echo $this->Html->css('jquery-ui');

echo $this->Html->script('jquery.min'); // js/jquery.min.js
echo $this->Html->script('jquery.tablesorter.min'); //
echo $this->Html->script('jquery.tablesorter.widgets.min');
echo $this->Html->script('jquery-ui-1.9.2.custom');
?>

</head>
<body>
<div class="head">
<h1>
	<table>
		<tr>
			<td>
				<?php echo $this->Html->image('/_img/ffc_logo.png',array('height'=>70,'width'=>70,'align'=>'middle'));?>
			</td>
			<td>
				<span style='align:bottom'> Portail FFC </span>
			</td>
		</tr>
	</table>
</h1>
<p align="right" style="position: relative; right: 10px"> <?php echo $this->Html->link('déconnecter',array('controller'=>'users','action'=>'logout'), array('class'=>'logout')); ?></p>


 <div class="head-user">
   <div class="user-infos" >
      <ul class="my-account unstyled">
         <li> <?php echo $user['nom']. ' ' . $user['prenom'] . ' - ';
         	$first = true;
               foreach ($memberships as $membership) {
                  if ($first) {
                     $first = false;
                     echo  $membership['Membership']['club'];
                  } else {
                     echo  " - " . $membership['Membership']['club'];
                  }
                  
               }
         
         ?></li>
         
         <li> 
            <?php 
               $first = true;
               foreach ($roles as $role) {
                  if ($first) {
                     $first = false;
                     echo  $role;
                  } else {
                     echo  " - " . $role;
                  }
                  
               }
            ?>         
         </li>
      </ul>
   </div>
   <div class="navig">
      <ul style="white-space:nowrap">
         <?php
         
         foreach ($menu as $item){
              	if($item[2]){
	               echo "<li actif='true'>" . $this->Html->link($item[0],$item[1]) . "</li>";
	            } else {
	                echo "<li>" .  $this->Html->link($item[0],$item[1]) . "</li>";
	            }
         	
         } 
         
         ?>
      </ul>
   </div>
 </div>

</div>

<div class="main">

<?php 
if( isset($subMenu) ){
      echo $this->element('subMenu',array("content_for_layout"=>$content_for_layout,"subMenu"=>$subMenu));
}else {
   echo $this->Session->flash(); 
   echo $this->fetch('content'); 
}
?>
</div>


<div class="footer"> 
<div class="footer-copyright">Fédération Francophone de Canoé</div>
<div class="footer-version">ffcportail - released @released@ </div>

<?php echo $this->element('sql_dump');?>
</div>
</body>
</html>