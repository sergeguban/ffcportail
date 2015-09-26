<?php
class MessageLu extends AppModel
{
	var $primaryKey = false;
	
	function setMessageLu($messageId,$userId){
		$sql = "select count(*) from  message_lus where user_id=$userId and message_id=$messageId";
		$result = $this->query($sql);
		if($result[0][0]['count(*)'] == 0){
			$sql = "insert into message_lus  (`user_id` ,`message_id`) values ($userId,$messageId)";
			$this->query($sql);
		}
	}
}
?>