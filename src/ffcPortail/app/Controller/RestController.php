<?php



class RestController extends AppController {

	var $uses = array('Membership','User','Club');
	//var $components= array('CategoryCalculator');
	
	public $components = array();

	public function beforeFilter() {
		$this->Auth->allow('licence');
	}

	



	// http://127.0.0.1:8080/ffcportail/ffcportail/Rest/licence/CRBK
	public function licence($club) {
		$this->set('club',$club);
		$licencesProduced = $this->Membership->getAllLicenceCompetitionforOneClub($this->currentYear,$club);
		
		$licences = array(); 

		foreach ($licencesProduced as $licenceProduced) {
			$licence = array();
			
			$birthYear = strtok($licenceProduced['User']['date_naissance'], '-');
		    $age = $this->currentYear - $birthYear;
			
			
			$licence['fullname'] = $licenceProduced['User']['prenom'] . ' '  . $licenceProduced['User']['nom'] ;
			$licence['firstname'] = $licenceProduced['User']['prenom'];
			$licence['lastname'] = $licenceProduced['User']['nom'];
			$licence['birthday'] = $licenceProduced['User']['date_naissance'];
			$licence['category'] = $licenceProduced['Membership']['category'];
			$licence['age'] = $age;
			$licence['sexe'] = $licenceProduced['User']['sexe'];;
			
			$licence['licenceNumber'] = $licenceProduced['User']['ffc_id'] .'/' . $licenceProduced['Membership']['l_yearly_number'] ;
				
			array_push($licences,$licence);
		}
				
		$this->set('licences', $licences);
		$this->layout ='rest';
		$this->render('view_licence');
	}


}