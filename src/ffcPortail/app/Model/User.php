<?php
class User extends AppModel {

	//SELECT users.id , users.club, licences.type, licences.status FROM  users left join licences  on users.id = licences.user_id



	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	public function getAllNewUsers(){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT * from  users   where ffc_id is null order by nom, prenom');

	}

	public function getAllValidatedUsers(){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT * from  users   where ffc_id is not null order by nom, prenom');

	}

	public function findStrongDuplicates($user){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT * from  users   where  (nom=? and prenom=?) and (id <> ? and ffc_id IS NOT NULL) order by nom', array($user['nom'],$user['prenom'],$user['id']));

	}
	
	
	public function findDuplicates($user){
		$db = $this->getDataSource();
		return $db->fetchAll( 'SELECT * from  users   where  (nom=? or prenom=?) and (id <> ? and ffc_id IS NOT NULL)  order by nom', array($user['nom'],$user['prenom'],$user['id']));

	}


	public function getNumberOfUsersBelongingToClubByAge($club_acronyme){
		$db =$this->getDataSource();
		$numbers = array();
		for($i=1;$i<=10;$i++){
			$yearmax=date('Y')-($i-1)*10;
			$yearmin=date('Y')-$i*10+1;
			if($club_acronyme!='all'){
				$number = $db->fetchAll( 'SELECT COUNT(*) AS number FROM users WHERE (club=? and date_naissance>=? and date_naissance<=?)',array($club_acronyme,$yearmin.'0101',$yearmax.'1231'));
			}
			else{
				$number = $db->fetchAll( 'SELECT COUNT(*) AS number FROM users WHERE (date_naissance>=? and date_naissance<=?)',array($yearmin.'0101',$yearmax.'1231'));
			}
			$numbers[$i-1]=$number[0][0]['number'];
			
		}
		return $numbers;
		
	}

	public $validate =
	array(
	    'club' => array( 'rule' => 'notEmpty',
	     				  'message' => 'un club est obligatoire !'
	     				  ),
	     				  	
        'username' => array(
        					'rule1'=>array(
        						'rule' => 'notEmpty',
                            	'message' => 'un nom d\'utilisateur est obligatoire !'),
                            'rule2'=>array(
        						'rule' => 'isUnique',
                            	'message' => 'ce nom d\'utilisateur est d&eacute;j&agrave; utilis&eacute; !'),
	     				  	
	     				  	
	     				  ),
        'password' => array( 'rule' => 'notEmpty',
                             'message' => 'un mot passe est obligatoire !'
                             ),
        'nom' => array('rule' => 'notEmpty',
	     			   'message' => 'le nom est obligatoire !'
	     			   ),
        'prenom' => array('rule' => 'notEmpty',
	     			      'message' => 'le pr&eacute;nom est obligatoire !' 
	     			      ),
        'sexe' => array( 'rule' => array('inList', array('F', 'H')),
                         'message' => 'Le sexe doit &ecirc;tre d&eacute;fini, les  valeurs possible sont F, H !'
                         ),
        'date_naissance' => array( 'rule' => array('date'),
                                   'message' => 'Une date de naissance est obligatoire !',
                                   'allowEmpty' => false
                         ),
        'lieu_de_naissance' => array( 'rule' => 'notEmpty',
                                   'message' => 'Le lieu de naissance est obligatoire !'
                         ),
        'adresse' => array('rule' => 'notEmpty',
	     			      'message' => 'une adresse est obligatoire !' 
	     			      ),
        'code_postal' => array('rule' => 'notEmpty',
	     			      'message' => 'le code postale est obligatoire !' 
	     			      ),
        'ville' => array('rule' => 'notEmpty',
	      			      'message' => 'la ville est obligatoire !' 
	      			      ),

        'mail' => array( 'rule' => 'email',
                         'allowEmpty' => true,
                         'message' => 'L\'adresse mail n\'est pas valable !'
                         
                         )

                         );
}
?>