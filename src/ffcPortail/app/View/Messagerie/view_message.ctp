<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
echo $this->Html->css('styles');

?>

<STYLE type="text/css">
<!--
BODY {
	background-image: none;
}

#link {
	padding: 5px;
	background-color: #FFFFFF;
	position: absolute;
	display: none;
	border-color: #444141;
	border-style: solid;
	border-width: 1px;
	height: 55px;
	width: 350px;
	z-index: 2;
	left:20px;
	
}
#linkClose {
	padding: 0px;
	background-color: #FFFFFF;
	position:absolute;
	right: 5px;
	top:5px;
	
}

-->
</STYLE>

<?php 
echo $this->Html->script('jquery.min'); // js/jquery.min.js
?>
<SCRIPT language="javascript">


$(document).ready(function() {

	$('#linkText').select();
	
	$('#link').hide();
	$('#viewLink').click(function() {
		$('#link').show(100);
		$('#linkText').select();
		return false;
	});

	$('#linkClose').click(function() {
		$('#link').hide();
		return false;
	});

	
	$('#newListForm').hide();
	$('A.createList').click(function() {
		$('#newListForm').show();
		return false;
	});

	// Mouse over the author portrait
	$('#message #authorPhotoThumb').click(function(){
		$('#message #authorPhoto').show(500);
	});
	$('#message #authorPhoto').mouseout(function(){
		$('#message #authorPhoto').hide(500);
	});
	// Edit the title of a list
	$('.subscribeList .actions A.modify').click(function(){
		$(this).parent().parent().parent().children('FORM[name="listEditForm"]').show(200);
		return false;
	});
	$('.subscribeList FORM[name="listEditForm"] A.cancel').click(function(){
		$(this).parent().hide(200);
		return false;
	});
	// Delete the list
	$('.subscribeList .actions A.delete').click(function(){
		$(this).parent().parent().parent().children('FORM[name="listDeleteForm"]').show(200);
		return false;
	});
	$('.subscribeList FORM[name="listDeleteForm"] A.cancel').click(function(){
		$(this).parent().hide(200);
		return false;
	});
	// Close the list
	$('.subscribeList .actions A.close').click(function(){
		$(this).parent().parent().parent().children('FORM[name="listCloseForm"]').show(200);
		return false;
	});
	$('.subscribeList FORM[name="listCloseForm"] A.cancel').click(function(){
		$(this).parent().hide(200);
		return false;
	});
	// Re-open the list
	$('.subscribeList .actions A.reOpen').click(function(){
		$(this).parent().parent().parent().children('FORM[name="listCloseForm"]').show(200);
		return false;
	});
	$('.subscribeList FORM[name="listCloseForm"] A.cancel').click(function(){
		$(this).parent().hide(200);
		return false;
	});
	// Delete message
	$('#deleteMessage').click(function(){
	$('FORM[name="messageDeleteForm"]').show(200);
	return false;
	});
	$('FORM[name="messageDeleteForm"] a.cancel').click(function(){
	$('FORM[name="messageDeleteForm"]').hide(200);
	return false;
	});
	
	
});
</SCRIPT>
</HEAD>

<body>

<?php 
if($message == null){
	
}else {
	
	$url=$this->Html->url('/Messagerie', false);
?>


<DIV id="message">
			<DIV class="messageActions">
			<A class="reply" href="<?php echo "$url/createNewMessage/?id_parent=". $message['Message']['id'] .'&type='. $message['Message']['type'] .'&id_racine=' . $message['Message']['message_root_id'] . '&archive=' . $message['Message']['archive'] ?>"
				title="R&eacute;pondre &agrave; ce message" target="_parent">R&eacute;pondre</A>
			
			<?php if( $isAllowedForUpdate == true){
			
			echo $this->Html->link('Modifier', 
			                       array(
									    'controller' => 'Messagerie',
									    'action' => 'updateMessage',
									    '?' => array('messageId' => $message['Message']['id'], 'type' => $message['Message']['type'])
			                            ),
			                        array(
										'target' => '_parent',
										'class' => 'modify'
									    )
								   );
			echo $this->Html->link('Créer liste', 
			                        array( 'controller' => null),
			                        array('class' => 'createList')
								   );
			}	
		    if( $isAllowedForDelete == true){
					echo $this->Html->link('Supprimer', 
					                        array( 'controller' => null),
					                        array('class' => 'delete','id' => 'deleteMessage')
										   );
		?>
           <FORM name="messageDeleteForm" style="display:none" method="post" action="<?php echo $url ?>/effacerMessage/?id_message=<?php echo $message['Message']['id']?>&type=<?php echo $message['Message']['type']?>">
					<P class="error">Confirmez-vous la suppression du message ?</P>
					<INPUT type="submit" value="Confirmer">
					<A class="cancel" href="#">Annuler</A>
			</FORM>
         
         
        	<?php } ?>
				<FORM id="newListForm"  action="<?php echo $url ?>/addInscriptionList" method="post">
					<input type="hidden" name="data[Message][id]" value="<?php echo $message['Message']['id'] ?>"  />
					<input type="hidden" name="data[Message][type]" value="<?php echo $message['Message']['type']?>" id="MessageType" />
					<LABEL>Inscription Course : </LABEL><input type="checkbox" name="data[InscriptionList][isCourse]" value="1"> 
					<BR>Donnez un titre à votre liste : <INPUT name="data[InscriptionList][description]" type="text" size="50"><INPUT type="submit" value="Créer la liste"><BR><BR>
				</FORM>
				
			</DIV>
			<A id="viewLink"  href="#" ><?php echo $this->Html->image('/_img/link.png'); ?></A>
			<DIV id="link">
			     <a id="linkClose"  href="#" ><?php echo $this->Html->image('/_img/close.png'); ?></a>
			    <div>
			    <p> Collez le lien suivant dans un e-mail ou dans un message :</p>
				<input id="linkText" type="text" readonly="readonly" checked="checked" size="60" value="<?php echo $this->Html->url('/Messagerie/messages/', true) .$message['Message']['type']."/".$message['Message']['id']  ?> "/>
                 </div>			
			</DIV>
			<DIV id="header">
			<P><LABEL>Auteur : </LABEL><?php echo $message['User']['nom'] . " " .$message['User']['prenom']?></P>
			<P><LABEL>Date : </LABEL><?php echo $message['Message']['message_date'] ?></P>
			<P><LABEL>Heure : </LABEL><?php echo $message['Message']['message_heure'] ?></P>
			<?php if($isCalenderDateDisplayed == true){
			list($year,$month,$day) = split("-",  $message['Message']['calendar_start_date']);
			
		    ?>
			<P><LABEL>Date Agenda : </LABEL><a href="<?php echo $this->Html->url('/Calendar', false); ?>/index/<?php echo "$year/$month"?>" target="_parent"><?php  echo $message['Message']['calendar_start_date'];?></a></P>
			<?php 
			}
			?>
			</DIV>
			<DIV id="text">
			<H1><?php echo $message['Message']['message_objet'] ?></H1>
			<?php echo $message['Message']['message'] ?>
			</DIV>
		
			<?php foreach ($messageInscriptions as $messageInscription) {?>
					<DIV class="subscribeList">
					<?php  if ( $messageInscription['InscriptionList']['closed'] == true){?>
					   <p class="error">Liste cl&ocirc;turée</p>
					<?php }?>
					
                    <h2><?php echo $messageInscription['InscriptionList']['description']?> ( <?php  print sizeof($messageInscription['Inscription'])?> inscrits )
		         
					<?php 
					if( $isAllowedForUpdate == true){
					// Edit/Delete List form
					?>
					<SPAN class="actions">
						<A href="#" class="modify" title="Modifier le titre">Modifier</A>
						<A href="#" class="delete" title="Supprimer cette liste">Supprimer</A>
						<?php  if ( $messageInscription['InscriptionList']['closed'] == false){?>
					     <A href="#" class="close" title="Cloturer cette liste">Cloturer</A>
					    <?php } else{?>
						 <A href="#" class="reOpen" title="Réouvrir cette liste">Réouverture</A>
					    <?php }?>
					</SPAN>
               </h2>
					 
					<FORM name="listEditForm" style="display:none" method="post" action="<?php echo $url ?>/updateInscriptionDescription">
						<INPUT name="data[InscriptionList][description]" type="text" size="50" value="<?php echo $messageInscription['InscriptionList']['description']?>">
						<input name="data[InscriptionList][id]" type="hidden" value="<?php echo $messageInscription['InscriptionList']['id']?>">
						<input name="data[InscriptionList][id_message]" type="hidden" value="<?php echo $message['Message']['id'] ?>">
						<INPUT type="submit" value="Modifier le titre">
						<A class="cancel" href="#">Annuler</A>
					</FORM>
					<FORM name="listDeleteForm" style="display:none" method="post" action="<?php echo $url ?>/deleteInscriptionList">
						<P class="error">Confirmez-vous la suppression de cette liste ? Les inscrits seront perdus...</P>
						<input name="data[InscriptionList][id]" type="hidden" value="<?php echo $messageInscription['InscriptionList']['id']?>">
						<input name="data[InscriptionList][id_message]" type="hidden" value="<?php echo $message['Message']['id'] ?>">
						<INPUT type="submit" value="Confirmer">
						<A class="cancel" href="#">Annuler</A>
					</FORM>
					<FORM name="listCloseForm" style="display:none" method="post" action="<?php echo $url ?>/closeInscriptionList">
						<P class="error">
							<?php if ( $messageInscription['InscriptionList']['closed'] == false){?>
					   			Confirmez-vous la cloture de cette liste ?
					       <?php }else{?>
					       Confirmez-vous la réouverture de cette liste ? 
					       <?php }?>
					    </P>
						<input name="data[InscriptionList][id]" type="hidden" value="<?php echo $messageInscription['InscriptionList']['id']?>">
						<input name="data[InscriptionList][id_message]" type="hidden" value="<?php echo $message['Message']['id'] ?>">
						<input name="data[InscriptionList][closed]" type="hidden" value="<?php echo ($messageInscription['InscriptionList']['closed'] + 1) % 2 ?>">
						<INPUT type="submit" value="Confirmer">
						<A class="cancel" href="#">Annuler</A>
					</FORM>
					<?php }?>
					<form method="post" action="<?php echo $url ?>/register/" name="register<?php echo $messageInscription['InscriptionList']['id']?>">
						<TABLE class="dataLines contactList" cellspacing="0">
							<THEAD>
								<TR>
									<TH>Nom</TH>
									<TH>Prénom</TH>
									<?php if( $messageInscription['InscriptionList']['isCourse'] == true){?>
									<TH>licence</TH>
									<TH>cat&eacute;gorie</TH>
									<?php }?>
									<TH>Commentaire</TH>
									<TH>Inscrit par</TH>
									<TH>&nbsp;</TH>
								</TR>
							</THEAD>

			        <?php foreach ($messageInscription['Inscription'] as $inscription) {?>
								<TR>
									<TD><?php echo $inscription['Inscription']['nom'] ?>&nbsp;</TD>
									<TD><?php echo $inscription['Inscription']['prenom'] ?>&nbsp;</TD>
									<?php if( $messageInscription['InscriptionList']['isCourse'] == true){?>
									<TD><?php echo $inscription['Inscription']['licence'] ?>&nbsp;</TD>
									<TD><?php echo $inscription['Inscription']['categorie'] ?>&nbsp;</TD>
									<?php }?>
									<TD><?php echo $inscription['Inscription']['comment'] ?>&nbsp;</TD>
									<TD><?php echo $inscription['User']['nom'] . ' ' . $inscription['User']['prenom'];?></TD>
									<TD align="center">
									   <?php 
									   	if($inscription['Inscription']['isOwner'] == true  && $messageInscription['InscriptionList']['closed'] == false){?>
									   	  <A href="<?php echo $url ?>/unregister/<?php echo $inscription['Inscription']['id']."/".$message['Message']['id']?>" class="remove" title="Supprimer cette inscription">&nbsp;</A>
									   <?php
			                         	}
									   ?>
									   &nbsp;	
						   			</TD>
					 			</TR>
						
				  	<?php }?>
					<?php if ( $isAllowedForRegisterInscription == true && $messageInscription['InscriptionList']['closed'] == false ) {?>
					
 					          <TR class="subscribeLine">
								  <TD><INPUT type="text" name="data[nom]" value="<?php  echo $memberConnected['nom'] ?>" size="20"/></TD>
								  <TD><INPUT type="text" name="data[prenom]" value="<?php  echo $memberConnected['prenom'] ?>" size="20" /> </TD>
								  <?php if( $messageInscription['InscriptionList']['isCourse'] == true){?>
									<TD><INPUT type="text" name="data[licence]" value="<?php  echo 'licenceNumber' ?>" size="10"></TD>
									<TD> <?php  $options=array(	'Pupille fille'=>'Pupille(...10) fille ',
								    							'Pupille garçon'=>'Pupille(...10) garçon',
								    							'Minime fille'=>'Minime(11-12) fille ',
								    							'Minime garçon'=>'Minime(11-12) garçon',
								    							'Cadette'=>'Cadette(13-14)',
								    							'Cadet'=>'Cadet(13-14)',
																'Aspirante'=>'Aspirante(15-16)',
																'Aspirant'=>'Aspirant(15-16)',
																'Junior Dame'=>'Junior(17-18) Dame',
																'Junior Homme'=>'Junior(17-18) Homme',
																'Senior Dame'=>'Senior(19-34) Dame',
																'Senior Homme'=>'Senior(19-34) Homme',
																'Veteran 1'=>'Vétéran 1 (35-44)',
																'Veteran 2'=>'Vétéran 2 (45-)'
								  								); 
		  								echo $this->Form->select('categorie',$options);  
		  								?>
		  							</TD>
								  <?php }?>
								  <TD> <INPUT type="text" name="data[comment]" value=""/></TD>
								  <TD>&nbsp;</TD>
								  <TD><INPUT type="submit" value="Inscrire"></TD>
							  </TR>
							  
					<?php 
					}
					?>
					</TABLE>
						<input type="hidden" name="data[inscription_list_id]"  value="<?php echo $messageInscription['InscriptionList']['id']?>" />
						<input type="hidden" name="data[message_id]"  value="<?php echo $message['Message']['id']?>" />
					</form>			  	
   			        </DIV>
			<?php } ?>
			
	</DIV>
<?php 
}
?>

</body>
</HTML>
