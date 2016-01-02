<?php

class LicencesController extends AppController {
	var $uses = array('User','Membership','Constants');
	
	public function beforeFilter() {
		$this->Auth->deny('add');
	}
	
    public function addBySecretaire($id=0,$club, $type,$downriver,$slalom,$flatwater,$marathon,$polo) {
		$this->security_check($club);
    	if ($id != 0) {
    		$data['Membership']['club']=$club;
			$data['Membership']['id']=$id;
			$data['Membership']['l_status']='validated';
			$data['Membership']['l_type']=$type;
			$data['Membership']['l_downriver']=$downriver;
			$data['Membership']['l_slalom']=$slalom;
			$data['Membership']['l_flatwater']=$flatwater;
			$data['Membership']['l_marathon']=$marathon;
			$data['Membership']['l_polo']=$polo;
				
				
			$data['Membership']['licence']=1;
			$data['Membership']['l_created']=date('Y-m-d');
			$this->Membership->save($data);
		}
	}
	
	public function add($club) {
		if ($this->request->is('post')) {
			if(strcmp($this->request->data['Licence']['type'.$club],'Disciplines')==0&&empty($this->request->data['Licence']['comp_type'.$club])){
				$this->Session->setFlash(__('Votre enregistrement a échoué, marquez les disciplines pour la licence.'));
				$this->redirect('/welcome/viewMyDossier');
				
			}
			else if(strcmp($this->request->data['Licence']['type'.$club],'Disciplines')!=0&&!empty($this->request->data['Licence']['comp_type'.$club])){
				$this->Session->setFlash(__('Votre enregistrement a échoué, si vous voulez une licence générale, ne marquez pas de discipline spécifique.'));
				$this->redirect('/welcome/viewMyDossier');
				
			}
			else{
				$data['Membership']['licence']=1;
				$data['Membership']['l_created']=date('Y-m-d');
				$data['Membership']['l_type']=$this->request->data['Licence']['type'.$club];
				$data['Membership']['l_status']='requested';
				$data['Membership']['year']=$this->currentYear;
				$data['Membership']['id']=$this->request->data['Licence']['id'.$club];
				$data['Membership']['user_id']=$this->Auth->User('id');
				
				if(strcmp($this->request->data['Licence']['type'.$club],'Disciplines')==0){
					$data['Membership']['l_downriver']=in_array('downriver',$this->request->data['Licence']['comp_type'.$club])?1:0;
					$data['Membership']['l_slalom']=in_array('slalom',$this->request->data['Licence']['comp_type'.$club])?1:0;
					$data['Membership']['l_polo']=in_array('polo',$this->request->data['Licence']['comp_type'.$club])?1:0;
					$data['Membership']['l_marathon']=in_array('marathon',$this->request->data['Licence']['comp_type'.$club])?1:0;
					$data['Membership']['l_flatwater']=in_array('flatwater',$this->request->data['Licence']['comp_type'.$club])?1:0;
				}
					
				if ($this->Membership->save($data)) {
					$this->Session->setFlash(__('Votre demande de licence a été enregistrée !'));
					$this->redirect('/welcome/viewMyDossier');
				} else {
					$this->Session->setFlash(__('Votre enregistrement a échoué, contactez l\'administrateur du site.'));
				}
			}
		}
		
	}

    public function valider($club,$licenceId) {
       $this->security_check($club);
    	$licence['Membership'] = array('id'=>$licenceId,"l_status"=>"validated");
       $this->Membership->save($licence);
       $this->Session->setFlash(__("La demande de licence numéro $licenceId a été validée !"));
       $this->redirect('/ManageMembers/licence/'.$club);
    }
    
    public function refuser($club,$licenceId) {
       $this->security_check($club);
    	$licence['Membership'] = array('id'=>$licenceId,"l_status"=>"refuser","licence"=>0); 
       $this->Membership->save($licence);
       
       $this->Session->setFlash(__("La demande de licence numéro $licenceId a été refusée !"));
       $this->redirect('/ManageMembers/licence/'.$club);
    }
    
    public function produced($licenceId) {
       $licence['Licence'] = array('id'=>$licenceId,"status"=>"produced"); 
       $this->Licence->save($licence);
       $this->Session->setFlash(__("La demande de licence numéro $licenceId a été produite !"));
       $this->redirect('/ManageLicences/licence/'.$club);
    }
    
  public function requestAndValidateLicences($club){
  	$this->security_check($club);
  	$data=$this->data;
  	
  	// search for errors in form
  	// tourism index is taken just to have the keys
  	foreach($data['tourism'] as  $key=>$value){
  		if(($data['downriver'][$key]!=0||$data['slalom'][$key]!=0||$data['flatwater'][$key]!=0||$data['marathon'][$key]!=0||$data['polo'][$key]!=0)&&($value==1)){
   			$this->Session->setFlash("Erreur dans le formulaire: vous ne pouvez pas mettre TOURISME ET des disciplines."); 
   			$this->redirect('/ManageMembers/licence/'.$club);
  		}
  		else if(($data['downriver'][$key]!=0||$data['slalom'][$key]!=0||$data['flatwater'][$key]!=0||$data['marathon'][$key]!=0||$data['polo'][$key]!=0)&&($data['competition'][$key]==1)){
  			$this->Session->setFlash("Erreur dans le formulaire: vous ne pouvez pas mettre COMPETITION GENERALE ET des disciplines.");	
  			$this->redirect('/ManageMembers/licence/'.$club);
  		}
  		else if ($value==1&&$data['competition'][$key]==1){
  			$this->Session->setFlash("Erreur dans le formulaire: vous ne pouvez pas mettre COMPETITION GENERALE ET TOURISME.");
  			$this->redirect('/ManageMembers/licence/'.$club);
  		}
  	}
  	
  	// add license requests
  	foreach($data['tourism'] as  $key=>$value){
  		
  			if($value==1){
	  			$this->addBySecretaire($key,$club,'Tourisme',0,0,0,0,0);
	  		}
	  		else if($data['competition'][$key] == 1){
	  			$this->addBySecretaire($key,$club,'Competition',0,0,0,0,0);
	  		}
	  		else if($data['downriver'][$key]!=0||$data['slalom'][$key]!=0||$data['flatwater'][$key]!=0||$data['marathon'][$key]!=0||$data['polo'][$key]!=0){
	  			$this->addBySecretaire($key,$club,'Disciplines',$data['downriver'][$key],$data['slalom'][$key],$data['flatwater'][$key],$data['marathon'][$key],$data['polo'][$key]);
	  		}
  		
  		
  	}	
  	
	/*$data=$this->data;
  	if($this->isManageAutorisationAllowed()){
  		$users=$this->User->find('all',array('fields'=>array('User.id','User.club')));
	  	foreach($users as $user){
	  		if($data['tourism'][$user['User']['id']]==1){
	  			$this->addBySecretaire($user['User']['id'],$user['User']['club'],'Tourisme');
	  		}
	  		if($data['competition'][$user['User']['id']]==1){
	  			$this->addBySecretaire($user['User']['id'],$user['User']['club'],'Competition');
	  		}
	  	}
  	}
  	else{
	  	$club=$this->Session->read('Auth.User.club');
	  	$users=$this->User->find('all',array('fields'=>array('User.id'),'conditions'=>array('club'=>$club)));
	  	foreach($users as $user){
	  		if($data['tourism'][$user['User']['id']]==1){
	  			$this->addBySecretaire($user['User']['id'],$club,'Tourisme');
	  		}
	  		if($data['competition'][$user['User']['id']]==1){
	  			$this->addBySecretaire($user['User']['id'],$club,'Competition');
	  		}
	  	}
  	}
  	*/
  	$this->Session->setFlash("Enregistrement réussi");
  	$this->redirect('/ManageMembers/licence/'.$club);
  	
  	
  }
 public function security_check($club,$id=0){
   		if(!($this->Membership->isManageMemberAllowed($this->Session->read('Auth.User.id'),$club, $this->currentYear))){
   			$this->Session->setFlash("Vous n'avez pas le droit de voir/changer les membres du ".$club."!");
       		$this->redirect("/welcome/index");
   		}
   		if($id!=0){
   			if(!($this->Membership->isManageMemberIdAllowed($club,$id,$this->currentYear))){
   				$this->Session->setFlash("Vous n'avez pas le droit de voir/changer les membres du ".$club."!");
       			$this->redirect("/welcome/index");
   			}
   		}
   }
    
    
    
    
}
?>