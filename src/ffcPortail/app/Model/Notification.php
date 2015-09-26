<?php
class Notification extends AppModel {

  


	public function getAllWaitingAutorisationsRequest(){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Notification.*, User.id, User.nom, User.prenom, User.club from  notifications as Notification left join users as User on Notification.user_id = User.id  where status = ? and type= ?',
   		  array('wait','autorisation')
		);
	}
}
?>