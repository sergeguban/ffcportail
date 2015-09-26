<?php
class ConsultationController extends AppController {
	var $uses = array('Membership','User','Club','Aros');
	//var $components= array('CategoryCalculator');
	var $helpers=array('Html');
	public function isAuthorized(){
		return $this->isConsultationAllowed();
	}
	public function beforeFilter() {
		// the controller decide if the authorization is allowed via isAuthorized() method
		$this->Auth->authorize = array('Controller');
	}



	public function beforeRender(){
		AppController::beforeRender();
		$subMenu = array(
		array ("Licences Compet","/Consultation/index",  $this->params['action'] == 'index'  ),
		array ("Membres",   "/Consultation/members",$this->params['action'] == 'members' )
		//,
		//array ("Clubs", "/Consultation/clubs",$this->params['action']=='clubs')
		);
		$this->set('subMenu',$subMenu);



	}

	public function index(){
		$licencesCompetition = $this->Membership->getAllLicenceCompetition($this->currentYear);
		$this->set('licencesCompetition', $licencesCompetition);
		$this->layout = 'connected';
			
			
	}

	public function downloadPdf() {
		$licencesProduced = $this->Membership->getAllLicenceCompetition($this->currentYear);
		$this->set('licencesProduced',$licencesProduced);
		$this->layout='pdf';
		$this->render();
	}
	

	public function members() {
		$members = $this->Membership->find('all',array('conditions'=>array('year'=>$this->currentYear)));
		$this->set('members', $members);
		
		$this->layout = 'connected';
			
	}

	public function downloadMembersPdf() {
		$members = $this->Membership->find('all',array('conditions'=>array('year'=>$this->currentYear)));
		$this->set('members', $members);
		$numberMembers=0;
		foreach($members as $member)if($member['User']['ffc_id']!=NULL)$numberMembers++;
		$this->set('numberMembers',$numberMembers);
		$this->layout='pdf';
	}
	/*public function clubs(){
		$clubs =$this->Club->find('all',array('order'=>array('Club.id')));
		foreach($clubs as &$club){
			$club['Club']['total']=count($this->User->find('all',array('conditions'=>array('User.club'=>$club['Club']['acronyme']))));
			$club['Club']['totalWomen']=count($this->User->find('all',array('conditions'=>array('User.sexe'=>'F','User.club'=>$club['Club']['acronyme']))));
			$club['Club']['totalMen']=count($this->User->find('all',array('conditions'=>array('User.sexe'=>'H','User.club'=>$club['Club']['acronyme']))));
			$totalByAge=$this->User->getNumberOfUsersBelongingToClubByAge($club['Club']['acronyme']);
			$club['Club']['totalByAge']=$totalByAge;
			$club['Club']['competitorsByCategory']=$this->Licence->getNumberOfLicenceCompetitionByClubByCategory($club['Club']['acronyme']);
			$club['Club']['clubSecretaries']=$this->__getAros($club['Club']['id'],'clubSecretaire');
			$club['Club']['arbitres']=$this->__getAros($club['Club']['id'],'arbitre');
		}
		
		$federation=array();
		$federation['acronyme']='FFC';
		$federation['description']='F&eacute;d&eacute;ration Francophone de Cano&#235;';
		$federation['total']=count($this->User->find('all'));
		$federation['totalWomen']=count($this->User->find('all',array('conditions'=>array('User.sexe'=>'F'))));
		$federation['totalMen']=count($this->User->find('all',array('conditions'=>array('User.sexe'=>'H'))));
		$federation['totalByAge']=$this->User->getNumberOfUsersBelongingToClubByAge('all');
		$federation['competitorsByCategory']=$this->Licence->getNumberOfLicenceCompetitionByClubByCategory('all');
		$federation['federalSecretaries']=$this->__getAros('all','federalSecretaire');
		
		$this->set('federation',$federation);
		$this->set('clubs',$clubs);
		$this->layout='connected';
		
	}
	*/
	
	/*public function viewResponsable($id){
		$this->set('user',$this->User->findById($id));
		$this->layout='connected';
	} */
	/*private function __getAros($clubId,$aroAlias){
		if($clubId=="all")return $this->Aros->getAllUsersForGroup($aroAlias);
		return $this->Aros->getAllUsersForGroupForClub($aroAlias,$clubId);
	}*/




}