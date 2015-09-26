<?php
class Message extends AppModel
{
	// Its always good practice to include this variable.
	var $name = 'Message';
	var $primaryKey = 'id';

	var $belongsTo  = array('User' => array('className'=>'User','foreignKey'=>'user_id'));
	var $validate = array(
	'message_objet' => array('rule' => 'notEmpty','message' =>'Titre du message obligatoire'),
	);

	function deleteAllId($ids){
		$first= true;
		$idsString="";
		foreach ($ids as $id){
			if($first){
				$idsString = $idsString . $id;
				$first=false;
			}
			else 	$idsString = $idsString . "," . $id;
		}
		$sql = "delete from messages where id in ($idsString)";
		$this->query($sql);
		$sql = "delete from message_lus where message_id in ($idsString)";
		$this->query($sql);
		
		foreach ($ids as $messageId) {
			$this->_deleteInscription($messageId);
		}
	}

	function _deleteInscription($messageId){
		//delete inscriptions listattached a this messageId
		$sql = "SELECT `id`  FROM `inscription_lists` WHERE `message_id` = $messageId";
		$result = $this->query($sql);
		foreach ($result as $inscriptionId) {
			$sql = "delete from inscriptions where inscription_list_id = " . $inscriptionId['inscription_lists']['id'];
			$this->query($sql);
		}
		$sql = "delete from  inscription_lists where message_id = " .  $messageId;
		$this->query($sql);
	}
	

	function getMessagesList($type,$reader_user_id){
		
		$sql = "SELECT messages.*, message_lus.user_id as readed FROM `messages`left join message_lus on messages.id = message_lus.message_id and message_lus.user_id = " .$reader_user_id . " where messages.type = '". $type ."'"; 
        $result = $this->query($sql);
		return $result;
	}
	
	
	
	function getLastId(){
		$sql = "select max(id) from messages";
		$result = $this->query($sql);
		return $result[0][0]['max(id_message)'];
	}
	/**
	 * Return something like this
	 *
	 * [0] => Array
	 (
	 [messages] => Array
	 (
	 [id_message] => 21176
	 [id_parent] => 0
	 [message] => <p>test</p>
	 [id_membre] => 1
	 [id_racine] => 0
	 [message_date] => 2010-12-15
	 [message_heure] => 13:48:28
	 [message_objet] => calendar
	 [privilege] => 4
	 [type] => cal
	 [calendar_start_date] => 2010-12-26
	 [calendard_end_date] => 0000-00-00
	 )

	 )
	 *
	 * Enter description here ...
	 * @param $year
	 * @param $month
	 */
	function getCalendarMessage($year,$month){
		$sql = "SELECT * FROM messages WHERE Month(calendar_start_date) =$month && Year(calendar_start_date) = $year";
		$result = $this->query($sql);
		return $result;
	}

	function getWelcomePageMessages(){
		$sql = "SELECT * FROM messages WHERE on_welcome_page=1";
		$result = $this->query($sql);
		return $result;
	}
	
	function setMessageRootId($messageId){
		$sql = "update messages SET message_root_id=$messageId  WHERE  id=$messageId ";
		$this->query($sql);
	}

	function archiveMessageGroup($messageId){
		$sql = "update messages SET archive=1 where id_racine=$messageId";
		$this->query($sql);
	}
	
}
?>