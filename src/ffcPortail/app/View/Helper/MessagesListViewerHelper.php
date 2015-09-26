<?php
/**
 [Message] => Array
 (
 [id_message] => 21057
 [id_parent] => 21053
 [message] => sauf si la course est �  10h
 [id_membre] => 8
 [id_racine] => 127
 [message_date] => 2010-10-14
 [message_heure] => 22:30:03
 [message_objet] => Pas moi.
 [privilege] => 4
 [type] => mes
 )

 [Membre] => Array
 (
 [id_membre] => 8
 [membre_nom] => Boucher
 [membre_prenom] => Corentin
 [membre_date_naissance] => 1985-12-31
 [membre_sexe] => M
 [membre_mail] => cobouche@ulb.ac.be
 [membre_tel_fixe] => 02/267 08 71
 [membre_tel_portable] => 0486 84 72 68
 [membre_adresse] => rue st amand n°110
 [membre_code_postal] => 1853
 [membre_ville] => strombeek
 [membre_pays] => belgique
 [membre_login] => corentin
 [membre_pw] => chouchou
 [id_privilege] => 2
 [photoType] => jpg
 [photoVersion] => 1
 [membre_licence] =>
 )


 **/



class MessagesListViewerHelper extends Helper
{
	var $helpers = array('Html');
	var $allMessages;
	var $url;
	var $target;
	var $currentFocusMessageId;
	
	function viewMessages($allMessages,$url, $target, $currentFocusMessageId=-1)
	{
		if(!isset($currentFocusMessageId)){
			$currentFocusMessageId = -1;
		}
		
		
		?>
		<script type="text/javascript">
		currentFocus = <?php echo $currentFocusMessageId?> ;

      function setAsReaded(id) {
         if (currentFocus != -1) {
            document.getElementById(currentFocus).className = "readed";
         }
         document.getElementById(id).className = "focus";
         currentFocus = id;
      }
	      
		</script>
		<?php 
		$this->url = $url;
		$this->target = $target;
		$this->allMessages = $allMessages;
		$this->currentFocusMessageId = $currentFocusMessageId;
		usort($this->allMessages, "compareMessage");
		$this->displaySubMessages(0);
	}

	function displaySubMessages($messageId, $desc = false)
	{
		$step = 0;
			
			
		$subMessages = $this->getSubMessages($messageId);
		if(count($subMessages) == 0) return;
		?>
<UL class="messages">
<?php
foreach ($subMessages as $message){
	
	
	if($message["messages"]["id"] == $this->currentFocusMessageId){
		$classHref= 'class="focus"';
	} else if(isset($message["message_lus"]["readed"]) && $message["message_lus"]["readed"] >0 ){
		$classHref= 'class="readed"';
	} else {
		$classHref= 'class="new"';
	}

	if($message["messages"]["id_parent"] != 0){
		?>
	<LI class="updated"><?php 
	}else{?>
	<LI class="root bg<?php echo ($step + 1)?> evenStage"><?php 
	$step = $step + 1;
	$step = $step % 2;
	}
	?> 
	  <A name='<?php echo $message["messages"]["id"] ?>' id="<?php echo $message["messages"]["id"]?>"
	<?php echo $classHref?>
	        onClick="setAsReaded(<?php echo $message["messages"]["id"]?>)"
			href="<?php echo $this->url."/".$message["messages"]["id"] ;?>"
		    target="<?php echo $this->target?>"> 
	   
		<?php  
		if($message["messages"]["calendar_start_date"] != "0000-00-00"){ 
			list($year,$month,$day) = split("-", $message["messages"]["calendar_start_date"]);
			echo "$day/$month/$year ";
		}
		echo  $message["messages"]["message_objet"]?> </A> <?php
		$this->displaySubMessages($message['messages']['id']);
		?></LI>
		<?php }?>
</UL>
		<?php
	}


	function getSubMessages($parentMessageId){
		$subMessages= array();
		foreach ($this->allMessages as $message){
			if ($message["messages"]["id_parent"] == $parentMessageId) {
				$subMessages[]=$message;
			}
		}
		if($parentMessageId == 0){
			usort($subMessages, "compareMessageDesc");
		}

		return $subMessages;
	}
}

function compareMessage($messageA, $messageB)
{
	if($messageA["messages"]["calendar_start_date"] != "0000-00-00"){
		if ($messageA["messages"]["calendar_start_date"] == $messageB["messages"]["calendar_start_date"]) {
			return 0;
		}
		return ($messageA["messages"]["calendar_start_date"]> $messageB["messages"]["calendar_start_date"]) ? -1 : 1;
	} else {
		if ($messageA["messages"]["id"] == $messageB["messages"]["id"]) {
			return 0;
		}
		return ($messageA["messages"]["id"]< $messageB["messages"]["id"]) ? -1 : 1;
	}


}

function compareMessageDesc($messageA, $messageB)
{
	return compareMessage($messageB, $messageA);
}
?>