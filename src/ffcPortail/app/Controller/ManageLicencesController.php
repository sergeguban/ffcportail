<?php
class ManageLicencesController extends AppController {

	var $uses = array('Membership','User','Constant');

	public $components = array('Session');

	public function beforeFilter() {
		$this->Auth->deny('licence','members','download');
	}

	public function beforeRender(){
		AppController::beforeRender();
		$subMenu = array(
		array ("Licences","/ManageLicences/licence",  $this->params['action'] == 'licence'  ),
		array ("Nouveaux Membres","/ManageLicences/newMembers",$this->params['action'] == 'newMembers' || $this->params['action'] == 'memberControl')
		);
		$this->set('subMenu',$subMenu);

		if($this->params['action'] == 'produceLicences' || $this->params['action']   =='reproduceLicence'){
			$this->layout = 'pdf';
		} else {
			$this->layout = 'connected';
		}

	}


	public function newMembers (){
		$newUsers  = $this->User->getAllNewUsers();
		foreach($newUsers as &$newUser){
			$memberships=$this->Membership->getMembershipsByUserByYear($newUser['users']['id'],$this->currentYear);
			$newUser['users']['club']='';
			foreach($memberships as $membership){
				$newUser ['users']['club'].=$membership['Membership']['club'].' ';
			}
		}
		$this->set('newUsers',$newUsers);
	}

	public function memberControl($id) {
		$newUser  = $this->User->findById($id);
		$duplicates  = $this->User->findDuplicates($newUser['User']);
		$strongDuplicates  = $this->User->findStrongDuplicates($newUser['User']);
		$memberships=$this->Membership->getMembershipsByUserByYear($newUser['User']['id'],$this->currentYear);
		$newUser['User']['club']='';
		foreach($memberships as $membership){
			$newUser['User']['club'].=$membership['Membership']['club'].' ';
		}
		foreach($duplicates as &$duplicate){
			$memberships=$this->Membership->getMembershipsByUserByYear($duplicate['users']['id'],$this->currentYear);
			//$this->Session->setFlash(json_encode($memberships));
			$duplicate['users']['club']='';
			foreach($memberships as $membership){
				$duplicate['users']['club'].=$membership['Membership']['club'].' ';			
			}
		}
		foreach($strongDuplicates as &$strongDuplicate){
			$memberships=$this->Membership->getMembershipsByUserByYear($strongDuplicate['users']['id'],$this->currentYear);
			$strongDuplicate['users']['club']='';
			foreach($memberships as $membership){
				//$strongDuplicate['users']['club']=($strongDuplicate['users']['club']==0?'':$strongDuplicate['users']['club']).$membership['Membership']['club'].' ';
				$strongDuplicate['users']['club'].=$membership['Membership']['club'].' ';
			}
		}
		$this->set('newUser',$newUser['User']);
		$this->set('strongDuplicates',$strongDuplicates);
		$this->set('duplicates',$duplicates);
	}

	public function licence() {

		$licencesToProduce = $this->Session->read('licencesToProduce');
		$this->set('licencesToProduce', $licencesToProduce);

		$licencesValider = $this->Membership->getAllLicenceValidated($this->currentYear);
		$this->set('licencesValider', $licencesValider);
			
		$licencesProduced = $this->Membership->getAllLicenceProduced($this->currentYear);
		$this->set('licencesProduced', $licencesProduced);
		$this->render('licence');
			
	}

	public function prepareLicencesProduction(){
		$licencesValider=$this->Membership->getAllLicenceValidated($this->currentYear);

		$data = $this->data;
		$licencesToProduce='';
		foreach($licencesValider as $licence){
			if(isset($data['Membership'][$licence['Membership']['id']])&&$data['Membership'][$licence['Membership']['id']]==1){
				$licenceToSave['Membership'] = array('id'=>$licence['Membership']['id'],"l_status"=>"produced","l_yearly_number"=>$this->Constant->getNewYearlyNumber(),"l_modified"=>date('Y-m-d'));
				$this->Membership->save($licenceToSave);
				$savedLicence=$this->Membership->getLicenceById($licence['Membership']['id'],$this->currentYear);
				$licencesToProduce = $licencesToProduce . $licence['Membership']['id'] . ';';
			}
		}
		$licencesToProduce =  rtrim($licencesToProduce, ";");
		$this->Session->write('licencesToProduceCsv',$licencesToProduce);
		$this->redirect('/ManageLicences/licence');
	}


	public function produceLicences(){
		$licencesToProduceCsv = $this->Session->read('licencesToProduceCsv');
		$licencesIdToProduce = split(";",$licencesToProduceCsv );
		$licencesToProduce=array();
		foreach($licencesIdToProduce as $licenceId){
			$licence=$this->Membership->getLicenceByIdAndAppendCategory($licenceId,$this->currentYear);
			array_push($licencesToProduce,$licence[0]);
		}
			
		$this->set('licences',$licencesToProduce);
		$this->render();
	}


	public function reproduceLicence($licenceId){
		$licence=$this->Membership->getLicenceByIdAndAppendCategory($licenceId,$this->currentYear);
		$this->set('licences',$licence);
		$this->layout='pdf';
		$this->render('produce_licences');
	}

	public function validateNewMember(){
		if ( isset($this->data['User']['ffc_id']) && $this->data['User']['ffc_id'] != null){
			$this->saveOldFFCId();
		} else {
			$this->createANewFfcId();

		}
	}
	public function replaceMember(){
		$data=$this->data['User'];
		$memberships=$this->Membership->getMembershipsByUserByYear($data['new_id'],$this->currentYear);
		foreach($memberships as $membership){
			if($this->Membership->isMember($data['old_id'],$membership['Membership']['club'],$this->currentYear)){
				$this->Membership->delete($membership['Membership']['id']);
			}
			else{
				$this->Membership->save(array("id"=>$membership['Membership']['id'],"user_id"=>$data['old_id']));
			}
		}
		$this->User->delete($data[new_id]);
		$this->redirect('/ManageLicences/newMembers');
	}
	public function deleteNewMember() {
		if ( isset($this->data['User']['id']) ){
			$memberships=$this->Membership->getMembershipsByUserByYear($this->data['User']['id'],$this->currentYear);
			//$this->Session->setFlash(json_encode($memberships));
			foreach($memberships as $membership){
				$this->Membership->delete($membership['Membership']['id']);
			}
			$this->User->delete($this->data['User']['id']);
			$this->Session->setFlash('La demande du nouveau membre a été effacée !');

		}
		$this->redirect('/ManageLicences/newMembers');
	}
	public function supprimerDemande($id){
		$this->Membership->save(array('id'=>$id,'licence'=>0));
		$this->Session->setFlash('La demande de licence a &eacute;t&eacute; supprim&eacute;e!');
		$this->redirect('/ManageLicences/licence');
	}

	private function saveOldFFCId(){
		$ffcIdDb = $this->User->findByFfcId($this->data['User']['ffc_id']);
		if(empty($ffcIdDb)){
			$this->User->save($this->data['User']);
			$this->redirect('/ManageLicences/newMembers');
		} else {
			$this->Session->setFlash(__('L\'identifiant ' . $this->data['User']['ffc_id'] . ' est déjà utilisé par ' . $ffcIdDb['User']['nom'] . ' ' . $ffcIdDb['User']['prenom'] . ' !'));
			$id = $this->data['User']['id'];
			$this->redirect("/ManageLicences/memberControl/$id");
		}
	}

	private function createANewFfcId(){
		$newFfcId = $this->Constant->getNewFfcId();
		$user = array('id'=>$this->data['User']['id'], 'ffc_id' => $newFfcId);
		$this->User->save($user);
		$this->redirect('/ManageLicences/newMembers');

	}
	


}

?>