<?php
class InscriptionList extends AppModel
{
	var $primaryKey = false;

	
	function update($messageInscription){
		$query = "update inscription_lists set description='" . $messageInscription['description'] . "'  where id = " .$messageInscription['id']   ;
		$this->query($query);
	}
	function delete($id_inscription){
		$query = "delete from inscription_lists   where id = $id_inscription" ;
		$this->query($query);
		$query = "delete from inscription_lists   where id = $id_inscription" ;
		$this->query($query);
	}
	
	function close($id, $closed){
		$query = "update inscription_lists  set closed=$closed  where  id= $id"    ;
		$this->query($query);
	}
	
}
?>