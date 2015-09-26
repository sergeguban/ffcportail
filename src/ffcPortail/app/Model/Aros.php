<?php
class Aros extends AppModel {



   public function getAllUsersForGroup($groupAlias){
      $db = $this->getDataSource();
      return $db->fetchAll( "select User.* from users as User where id in (
											select foreign_key from aros where parent_id =
										  (SELECT id FROM aros WHERE alias= ?))",array($groupAlias)
      );
   }
   
   /*find all users belonging to club $club with right $groupAlias*/
   public function getAllUsersForGroupForClub($groupAlias,$club){
   	  $db=$this->getDataSource();
   	  return $db->fetchAll("select User.* from users as User where id in (select foreign_key from aros where parent_id=(SELECT id FROM aros WHERE alias = ?)) and club = ?",array($groupAlias,$club));
   }



   public function getAroIdForUserInGroup($userId,$groupAlias){
      $db = $this->getDataSource();
      return $db->fetchAll("select Aro.id from aros as Aro where parent_id = (SELECT id FROM aros WHERE alias=?) and foreign_key= ?",array($groupAlias,$userId));
   }

}
?>