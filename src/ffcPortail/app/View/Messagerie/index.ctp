<table>
  <tr>
  
  <?php
  // display all messages grouped by message type (discussion,information ..) with column layout
  foreach (array_keys($allMessages) as $messageType) {
  ?>  
        <td class="content">
	        <h3 class="messagesListTitle"><?php echo $allMessages[$messageType][1] ?></H3>
			<p><a class="write" href="<?php echo $this->Html->url("/Messagerie/createNewMessage/?id_parent=0&type=$messageType",true)?>" >Nouveau sujet</a></p>
			<?php $this->MessagesListViewer->viewMessages($allMessages[$messageType][0],$this->Html->url("/Messagerie/messages/$messageType",true),"_self");?>
		</td>
  <?php 
  }
  ?>
  </tr>
</table>

		
		
