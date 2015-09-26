<span class="left">
<table >
	<thead>
		<tr>
			<th>Demandeur</th>
			<th >Requête</th>
			<th >Date</th>
		</tr>
	</thead>

	<tbody>
	<?php

	foreach ($notificationsWait as $notificationWait){
		?>
		<tr>
			<td ><?php echo $notificationWait['User']['nom'] ." " .  $notificationWait['User']['prenom'] ?></td>
			<td><?php echo $notificationWait['Notification']['type']?></td>
			<td><?php echo $notificationWait['Notification']['created'] ?></td>
			<td><?php echo $this->Html->link('dossier',"/welcome/manageNotification/".$notificationWait['Notification']['user_id'] ); ?>
			</td>
		</tr>

		<?php
	}
	?>
	</tbody>
</table>
</span>

<?php if (isset($dossier)) {?>

<span>
<ul>
	<li><strong>Nom</strong><span><?php echo $dossier['User']['nom'] ?></span></li>
	<li><strong>Prénom</strong></li>
	<li><strong>date de naissance</strong></li>
</ul>
</span>
<?php }?>

