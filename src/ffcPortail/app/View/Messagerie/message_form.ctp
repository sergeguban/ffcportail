

<?php 
echo $this->Html->script('tiny_mce/tiny_mce.js');
echo $this->element('tiny');

?>


   <?php echo $this->Form->create('Message',
								  array('url'=>'/Messagerie/postMessage')
								  );
   ?>

<DIV id="message">
<DIV id="header">
<p><strong>Auteur : </strong><?php echo $membre['nom']. " " . $membre['prenom'];?>
</p>
<P><strong>Date : </strong><?php echo $this->data['Message']['message_date'];?></P>
<P><strong>Heure : </strong><?php echo  $this->data['Message']['message_heure'];?></P>
</DIV>
<DIV id="text">
<?php echo $this->Form->hidden('Message.id_parent');?> 
<?php echo $this->Form->hidden('Message.id');?> 
<?php echo $this->Form->hidden('Message.user_id');?>  
<?php echo $this->Form->hidden('Message.message_date');?> 
<?php echo $this->Form->hidden('Message.message_heure');?> 
<?php echo $this->Form->hidden('Message.type');?> 
<?php echo $this->Form->hidden('Message.id_racine');?> 
<?php echo $this->Form->hidden('Message.archive');?> 
 

<TABLE border="0" cellspacing="0" cellpadding="0">
	<TR>
		<TH>Sur page d'accueil:</TH>
		<TD><?php 
		$options=array(0=>'non',1=>'oui');
		$attributes=array('legend'=>false);
		echo $this->Form->checkbox('Message.on_welcome_page');
		?>
		</TD>
	</TR>
	
	<TR>
		<TH>Titre du message</TH>
		<TD><?php echo $this->Form->input('Message.message_objet', array('size'=>'60','label'=>false,'error' => array('wrap' => 'p', 'class' => 'error')))?>
		</TD>
	</TR>
	
	<?php if($isCalenderDateDisplayed == true){?>
	<TR>
		<TH>Date</TH>
		<TD><?php echo $this->Form->input('Message.calendar_start_date', array('label'=>false,'error' => array('wrap' => 'p', 'class' => 'error'),'dateFormat' => 'DMY','minYear' => date('Y')-1 
, 'maxYear' => date('Y')+2 ))?>
		</TD>
	</TR>
	<?php }?>
	<TR>
		<TH>Texte</TH>
		<TD><?php echo $this->Form->input('Message.message', array('rows' => '18', 'cols' => '130','label'=>false))?></TD>

	</TR>
	<TR>
		<TH>&nbsp;</TH>
		<TD><INPUT type="submit" name="send" value="Envoyer"/>
		&nbsp;&nbsp;&nbsp;
  <?php     echo $this->Html->link('Annuler', 
   									array(
										    'controller' => 'Messagerie',
    										'action' => 'messages',
    										 $this->data['Message']['type']
    								     )
    						       );?>
       </TD>
	</TR>
</TABLE>

</DIV>
</DIV>
</FORM>