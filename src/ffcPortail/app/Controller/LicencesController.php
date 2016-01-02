<?php

class LicencesController extends AppController {
	var $uses = array('User','Membership','Constants');
	
	public function beforeFilter() {
		$this->Auth->deny('add');
	}
	
    public function addBySecretaire($id=0,$club, $type) {
		$this->security_check($club);
    	if ($id != 0) {
    		$data['Membership']['club']=$club;
			$data['Membership']['id']=$id;
			$data['Membership']['l_status']='validated';
			$data['Membership']['l_type']=$type;
			$data['Membership']['licence']=1;
			$data['Membership']['l_created']=date('Y-m-d');
			$this->Membership->save($data);
		}
	}
	
	public function add($club) {
		if ($this->request->is('post')) {
			$data['Membership']['licence']=1;
			$data['Membership']['l_created']=date('Y-m-d');
			$data['Membership']['l_type']=$this->request->data['Licence']['type'.$club];
			$data['Membership']['l_status']='requested';
			$data['Membership']['year']=$this->currentYear;
			$data['Membership']['id']=$this->request->data['Licence']['id'.$club];
			$data['Membership']['user_id']=$this->Auth->User('id');
			if ($this->Membership->save($data)) {
				$this->Session->setFlash(__('Votre demande de licence a été enregistrée !'));
				$this->redirect('/welcome/viewMyDossier');
			} else {
				$this->Session->setFlash(__('Votre enregistrement a échoué, contactez l\'administrateur du site.'));
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
  	foreach($data['tourism'] as  $key=>$value){
  		if($value==1)$this->addBySecretaire($key,$club,'Tourisme');
  	}
  	foreach($data['competition'] as $key=>$value){
  		if($value==1)$this->addBySecretaire($key,$club,'Competition');
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