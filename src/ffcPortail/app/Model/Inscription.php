<?php
class Inscription extends AppModel
{
	var $primaryKey = false;
	var $belongsTo  = array('User' => array('className'=>'User','foreignKey'=>'user_id'));
	

	function deleteInscription($id){
		$sql = "delete from inscriptions where id = $id " ;
		$this->query($sql);
	}
	
}
?>