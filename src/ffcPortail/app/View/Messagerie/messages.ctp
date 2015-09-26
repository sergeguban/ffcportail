	<P>
	<?php 
	$url=$this->Html->url('/', false);
	if($archive == 0){
	?>
	<A 
	<?php if($messageType == "cal"){?>
		 class="write" href="<?php echo $url;?>/Calendar" 
	<?php } else {?>	
		 class="write" href="<?php echo $url;?>/Messagerie/createNewMessage/?id_parent=0&type=<?php echo $messageType?>" 
	<?php }?>		
				title="Ecrire un nouveau sujet">Nouveau sujet</A>
	<?php 
	} else {
	?>		
		Archives
		
	<?php 	
	}
	?>
			</P>
<table width="1050px" >
  <tr>
  	
    <td width="300">
    
		    <?php 
		        $url = $this->Html->url("/Messagerie/messagesList/$messageType", false);
				if($messageId != null){
					$url = $url . "/$messageId/$archive";
				}
			?>
			<IFRAME id="frameList" src="<?php echo $url?>" frameborder="0" hspace="0" vspace="0" width="300" height="450">
			 Votre navigateur est trop ancien : IFRAME non affiché...
			 </IFRAME>
    </td>
    <td align="left">
    
		<?php 
	    $url = $this->Html->url('/Messagerie/viewMessage', false);
		if($messageId != null){
			$url = $url . "/$messageId";
		}
		?>
		
		<IFRAME name="message" src="<?php echo $url?>" frameborder="0"  width="100%" height="450" SCROLLING=auto >
			 Votre navigateur est trop ancien : IFRAME non affiché...
			 </IFRAME>
    </td>
  </tr>
</table>
		
			 
			 
