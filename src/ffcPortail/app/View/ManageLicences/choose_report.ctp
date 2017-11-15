<h2>Rapports des membres</h2>
Vous pouvez g&eacute;n&eacute;rer des rapports annuels des membres, clubs, ... en cliquant sur les options que vous voulez.
<br/>
<br/>
<br/>
<div>
<?php echo $this->Form->create(null, array('url'=> array('controller'=>'ManageLicences',
                                             'action' => 'generateReport'))); ?>
<b>Choisissez les ann&eacute;es pour lesquelles vous voulez un rapport:</b>
<br/>
<br/>
	<table>
		<tr>
		<?php for($year=2014;$year<=date('Y');$year++){?>
			<td><?php echo $year;?></td>
		<?php }?>
		<td>Historique</td>
		
			
		</tr>
		<tr>
		<?php for($year=2014;$year<=date('Y');$year++){?>
			<td align='center' style="text-align:center"><?php echo $this->Form->checkbox('y'+$year,array('style'=>'float:none'));?></td>			
		<?php }?>
		<td align='center' style="text-align:center"><?php echo $this->Form->checkbox('history',array('style'=>'float:none'))?></td>
		</tr>
	</table>
<br/>
<br/>
<b>Rapports par club:</b>
<br/>
<br/>
	<table>
		<tr>
		<?php foreach($clubs as $club){
		?>
		<td align='center'><?php echo $club['Club']['id']?></td>
		<?php }?>
		</tr>
		<tr>
		<?php foreach($clubs as $club){
		?>
		<td align='center'><?php echo $this->Form->checkbox($club['Club']['id'],array('style'=>'float:none'))?></td>
		
		<?php }?>
		</tr>
	</table>
<br/>
<br/>
<b>Rapport f&eacute;d&eacute;ration:</b>
<br/>
<br/>
<table>
	<tr>
		<td>Rapport g&eacute;n&eacute;ral de la FFC:</td>
		<td><?php echo $this->Form->checkbox('fed')?></td>
	</tr>
</table>


<?php
	echo $this->Form->submit('Générer rapport');
  	echo $this->Form->end();
?>  
</div>                                           
