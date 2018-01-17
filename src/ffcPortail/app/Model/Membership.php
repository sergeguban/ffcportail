<?php
class Membership extends AppModel{
	var $belongsTo = array("User");
	
private $categories = array(10 => "pupille",
								12 => "minime",
								14 => "cadet",
								16 => "aspirant",
								18 => "junior",
								34 => "senior",
								44 => "vétéran 1",
								54 => "vétéran 2",
								110 => "vétéran 3"
								);
private $ageCategories = array(12=>0,18=>1,25=>2,35=>3,200=>4);


	public function getLicenceRequested($club,$year){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and Membership.club =? and Membership.year = ? order by nom',
		array(1,'requested',$club,$year));
	}

	public function getLicenceValidated($club,$year){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and Membership.club = ? and Membership.year =? order by nom',
		array(1,'validated',$club,$year));
	}


	public function getLicenceProduced($club,$year){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and Membership.club = ? and Membership.year =? order by nom',
		array(1,'produced',$club,$year));
	}


	public function getAllLicenceProduced($year){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and Membership.year =?  order by nom  ',
		array(1,'produced',$year));
	}

	public function getAllLicenceValidated($year){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and Membership.year =?  order by nom  ',
		array(1,'validated',$year));
	}
	public function getLicenceById($id,$year){
		$db= $this->getDataSource();
		return $db->fetchAll('SELECT Membership.*,User.id, User.ffc_id,User.nom,User.prenom,User.mail,User.date_naissance, User.lieu_de_naissance, User.sexe from memberships as Membership left join users as User on Membership.user_id =User.id where Membership.licence= 1 and Membership.id= ?  and Membership.year =?',
		array($id,$year));
	}

	public function getAllLicenceCompetition($year){
		$db = $this->getDataSource();
		$licencesCompetition = $db->fetchAll( 'SELECT Membership.*, User.id, User.ffc_id, User.nom, User.prenom, User.mail,User.date_naissance, User.lieu_de_naissance from  memberships as Membership left join users as User on Membership.user_id = User.id  where Membership.licence = ? and Membership.l_status = ? and (Membership.l_type= ? or Membership.l_type=?)  and Membership.year =? order by nom  ',
		array(1, 'produced','Competition','Disciplines',$year));

		$this->addCategory($licencesCompetition,$year);
		return $licencesCompetition;
	}


	private function addCategory(&$licences,$year ){
		foreach ($licences as &$licence) {
			$licence['Membership']['category'] = $this->getCategoryFromBirthDate($licence['User']['date_naissance'],$year);
		}
			
	}
	public function getLicenceByIdAndAppendCategory($id,$year){
		$licence=$this->getLicenceById($id,$year);
		$licence[0]['Membership']['category'] = $this->getCategoryFromBirthDate($licence[0]['User']['date_naissance'],$year);
		return $licence;
	}
	
	public function getMembershipsByUserByYear($user_id,$year){
		$db=$this->getDataSource();
		return $db->fetchAll('SELECT Membership.* from memberships as Membership where Membership.year=? and Membership.user_id= ?',
		array($year,$user_id));
	}
	public function isManageMemberAllowed($id,$club,$year){
		$conditions = array(
		    'Membership.user_id' => $id,
		    'Membership.club' => $club,
			'Membership.is_secretary' => 1,
		    'Membership.year' => $year
		);
		return $this->hasAny($conditions);
	
	}
	public function isManageMemberIdAllowed($club,$id_mem,$year){
		$conditions = array(
		    'Membership.user_id' => $id_mem,
		    'Membership.club' => $club,
			'Membership.year' => $year
		);
		return $this->hasAny($conditions);
	}
	public function isMember($id,$club,$year){
		$conditions = array(
		    'Membership.user_id' => $id,
		    'Membership.club' => $club,
			'Membership.year' => $year
		);
		return $this->hasAny($conditions);
	}
	public function loadHistory($club,$year){
		$db = $this->getDataSource();
		if ($club == 'all'){
			if ($year == 'all'){ //get most recent memberships of all members within the history of the club
				return $db->fetchAll(
						'SELECT Membership.*,User.* from memberships as Membership left join users as User on Membership.user_id=User.id
					where Membership.id
						= (SELECT t2.id FROM memberships t2 WHERE t2.user_id = Membership.user_id ORDER BY t2.year DESC LIMIT 1)
					ORDER BY Membership.year DESC');
			}else{
				return $db->fetchAll('SELECT Membership.*,User.* from memberships as Membership left join users as User on Membership.user_id =User.id where Membership.year=?',array($year));
			}}
		else{
			if ($year == 'all'){ //get most recent memberships of all members within the history of the club
				return $db->fetchAll(
						'SELECT Membership.*,User.* from memberships as Membership left join users as User on Membership.user_id=User.id 
						where Membership.club=? AND Membership.id 
							= (SELECT t2.id FROM memberships t2 WHERE t2.user_id = Membership.user_id AND t2.club=? ORDER BY t2.year DESC LIMIT 1)
						ORDER BY Membership.year DESC',array($club,$club));
			}else{
				return $db->fetchAll('SELECT Membership.*,User.* from memberships as Membership left join users as User on Membership.user_id =User.id where Membership.year=? and Membership.club=?',array($year,$club));	
			}
		}
	}
	public function loadClubSecretaries($year){
		$db=$this->getDataSource();
		return $db->fetchAll('SELECT Membership.*,User.* from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.is_secretary=1 and Membership.year=?',array($year));
	}
	
	

	public function loadStats($club, $year){
		$db=$this->getDataSource();
		$stats=array();
		if($club=='all'){
			//debug($db->fetchAll('SELECT User.* from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.ffc_id is not null',array($year)));
				
			$stats['age_total']['all']=$this->count_age($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.ffc_id is not null',array($year)),$year);
			$stats['age_total']['men']=$this->count_age($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.sexe=? and User.ffc_id is not null',array($year,'H')),$year);
			$stats['age_total']['women']=$this->count_age($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.sexe=? and User.ffc_id is not null',array($year,'F')),$year);
				
			$stats['comp_total']['all']=$this->count_comp($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.licence=? and Membership.l_type=? and Membership.year=? and User.ffc_id is not null',array(1,'Competition',$year)),$year);
			$stats['comp_total']['men']=$this->count_comp($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.licence=? and Membership.l_type=? and Membership.year=? and User.sexe=? and User.ffc_id is not null',array(1,'Competition',$year,'H')),$year);
			$stats['comp_total']['women']=$this->count_comp($db->fetchAll('SELECT User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.licence=? and Membership.l_type=? and Membership.year=? and User.sexe=? and User.ffc_id is not null',array(1,'Competition',$year,'F')),$year);
			
			$stats['gender_total']['men']=count($db->fetchAll('SELECT Membership.id from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.sexe=? and User.ffc_id is not null',array($year,'H')));
			$stats['gender_total']['women']=count($db->fetchAll('SELECT Membership.id from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.year=? and User.sexe=? and User.ffc_id is not null',array($year,'F')));
		}
		else{
			$stats['age_total']['all']=$this->count_age($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.year=?',array($club,$year)),$year);
			$stats['age_total']['men']=$this->count_age($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and User.sexe=? and Membership.year=?',array($club,'H',$year)),$year);
			$stats['age_total']['women']=$this->count_age($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and User.sexe=? and Membership.year=?',array($club,'F',$year)),$year);
			$stats['comp_total']['all']=$this->count_comp($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.licence=? and Membership.l_type=? and Membership.year=? ',array($club,1,'Competition',$year)),$year);
			$stats['comp_total']['men']=$this->count_comp($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.licence=? and Membership.l_type=? and Membership.year=? and User.sexe=?',array($club,1,'Competition',$year,'H')),$year);
			$stats['comp_total']['women']=$this->count_comp($db->fetchAll('SELECT Membership.year,User.date_naissance from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.licence=? and Membership.l_type=? and Membership.year=? and User.sexe=?',array($club,1,'Competition',$year,'F')),$year);
				
			
			$stats['gender_total']['men']=count($db->fetchAll('SELECT Membership.id from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.year=? and User.sexe=?',array($club,$year,'H')));
			$stats['gender_total']['women']=count($db->fetchAll('SELECT Membership.id from memberships as Membership left join users as User on Membership.user_id=User.id where Membership.club=? and Membership.year=? and User.sexe=?',array($club,$year,'F')));
			
		}
		return $stats;
	}
	
	private function count_age($memberships, $year){
		
		$stats=array_combine(array_values($this->ageCategories),array_fill ( 0,count($this->ageCategories),0));
		foreach($memberships as $membership){
				
			$stats[$this->getAgeCategoryFromBirthDate($membership['User']['date_naissance'], $year)]++;
				
		}
		
		return $stats;
	}
	private function count_comp($memberships, $year){
		$stats=array();
		$stats=array_combine(array_values($this->categories),array_fill ( 0,count($this->categories),0));
		foreach($memberships as $membership){
				
				$stats[$this->getCategoryFromBirthDate($membership['User']['date_naissance'], $year)]++;

		}
		return $stats;
	}
	
	
	
	/*public function getNumberOfLicenceCompetitionByClubByCategory($club_acronyme){
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
	*/
	
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
	
	public function getAgeCategoryFromBirthDate ($birthdate, $year)
	{
		$birthYear = strtok($birthdate, '-');
		$age = $year - $birthYear;
		return $this->findAgeCategory($age);
	}
	private function findAgeCategory($age){
		foreach ( $this->ageCategories as $key => $value) {
			if($age <= $key ){
				return $value;
			}
		}
	}
}

?>