<?php
class Licence extends AppModel {
	var $components = array('CategoryCalculator');
	var $belongsTo = array('User');
	private $categories = array(10 => "pupil",
								12 => "minime",
								14 => "cadet",
								16 => "aspirant",
								18 => "junior",
								34 => "senior",
								44 => "vétéran 1",
								54 => "vétéran 2",
								110 => "vétéran 3"
								);

	public function getLicenceRequested($club){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ? and Licence.club = ? order by nom',
		array('requested',$club));
	}

	public function getLicenceValidated($club){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ? and Licence.club = ? order by nom',
		array('validated',$club));
	}


	public function getLicenceProduced($club){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ?  and Licence.club = ? order by nom ',
		array('produced',$club));
	}


	public function getAllLicenceProduced(){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ?  order by nom  ',
		array('produced'));
	}

	public function getAllLicenceValidated(){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ? order by nom ',
		array('validated'));
	}
	public function getLicenceById($id){
		$db= $this->getDataSource();
		return $db->fetchAll('SELECT Licence.*,User.id, User.ffc_id,User.nom,User.prenom,User.mail,User.date_naissance, User.lieu_de_naissance, User.sexe from licences as Licence left join users as User on Licence.user_id =User.id where Licence.id='.$id);
	}

	public function getAllLicenceCompetition(){
		$db = $this->getDataSource();
		$licencesCompetition = $db->fetchAll( 'SELECT Licence.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  licences as Licence left join users as User on Licence.user_id = User.id  where Licence.status = ? and Licence.type= ?  order by nom  ',
		array('produced','Competition'));

		$this->addCategory($licencesCompetition);
		return $licencesCompetition;
	}


	private function addCategory(&$licences ){
		foreach ($licences as &$licence) {
			$licence['Licence']['category'] = $this->getCategoryFromBirthDate($licence['User']['date_naissance'],$this->currentYear);
		}
			
	}
	public function getLicenceByIdAndAppendCategory($id){
		$licence=$this->getLicenceById($id);
		$licence[0]['Licence']['category'] = $this->getCategoryFromBirthDate($licence[0]['User']['date_naissance'],$this->currentYear);
		return $licence;
	}
	
	public function getNumberOfLicenceCompetitionByClubByCategory($club_acronyme){
		if($club_acronyme!='all'){
			$licences=$this->find('all',array('conditions'=>array('Licence.club'=>$club_acronyme,'type'=>'Competition','year'=>Date('Y'),'status'=>'produced')));
		}
		else{
			$licences=$this->find('all',array('conditions'=>array('type'=>'Competition','year'=>Date('Y'),'status'=>'produced')));
		}
		$numberByCategory=array();
		foreach ($this->categories as $key => $value){
			$numberByCategory[$value]=0;
		}
		foreach($licences as $licence){
			
			$category=$this->getCategoryFromBirthDate($licence['User']['date_naissance'],Date('Y'));
			$numberByCategory[$category]++;
		}
		
		return $numberByCategory;
		
	}
	
	/**
	 *
	 * Return the competition category (pupille, minime, etc ...) compute from a birthdate for a specific year.
	 *
	 * birthdate as yyyy-mm-dd
	 * year as yyyy
	 *
	 *
	 *
	 * Enter description here ...
	 * @param $birthdate
	 * @param $year
	 */

	public function getCategoryFromBirthDate ($birthdate, $year)
	{
		$birthYear = strtok($birthdate, '-');
		$age = $year - $birthYear;
		return $this->findCategory($age);
	}

	 
	private function findCategory($age){

		foreach ( $this->categories as $key => $value) {
			if($age <= $key ){
				return $value;
			}
		}

	}
	
}
?>