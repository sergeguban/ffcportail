<?php
class ManageMembersController extends AppController {

   var $uses = array('User','Club','Membership');

   var $components = array('RandomGenerator');

   var $helpers = array('FieldError');

   public function beforeFilter() {
      $this->Auth->deny('licence','members','download');
   }

   public function beforeRender(){
      AppController::beforeRender();
      $subMenu = array(
      			
		      array ("Membres",array('controller'=>'ManageMembers','action'=>'members',$this->params['pass'][0]),  $this->params['action'] == 'members' ||
													      $this->params['action'] == 'addMember'||
													      $this->params['action'] == 'uploadMembers'||
 														  $this->params['action'] == 'confirmUploadMembers'||
													      $this->params['action'] == 'viewMember'||
													      $this->params['action'] == 'old_members_add'),
		      
		      array ("Licences",array('controller'=>'ManageMembers','action'=>'licence',$this->params['pass'][0]),$this->params['action'] == 'licence'),
			  array ("Fiche club",array('controller'=>'ManageMembers','action'=>'fiche',$this->params['pass'][0]),$this->params['action'] == 'fiche'),
			  array("Historique membres",array('controller'=>'ManageMembers','action'=>'history_members',$this->params['pass'][0]),$this->params['action'] == 'history_members')
      );
      $this->set('subMenu',$subMenu);

      if($this->params['action'] == 'download'){
         $this->layout = 'empty';
      } else {
         $this->layout = 'connected';
      }
       


   }


   public function licence($club) {
      $this->security_check($club);
      $this->set('club',$club);   	
   	  $this->set('members',$this->Membership->loadHistory($club,$this->currentYear));
      $licencesAValider = $this->Membership->getLicenceRequested($club,$this->currentYear);
     
      $this->set('licencesAValider', $licencesAValider);
       
      $licencesValider = $this->Membership->getLicenceValidated($club,$this->currentYear);
      $this->set('licencesValider', $licencesValider);
       
      $licencesProduced = $this->Membership->getLicenceProduced($club,$this->currentYear);
      $this->set('licencesProduced', $licencesProduced);
      
      $licencesAlreadyAsked=$this->Membership->find('all',array('fields'=>'user_id','conditions'=>array('year'=>$this->currentYear,'Membership.club'=>$club,'licence'=>1)));
      $idsLicencesAlreadyAsked = array();
      foreach($licencesAlreadyAsked as $licenceAlreadyAsked){
      	array_push($idsLicencesAlreadyAsked,$licenceAlreadyAsked['Membership']['user_id']);
      }
      $this->set('licencesAlreadyAsked',$idsLicencesAlreadyAsked);
      
      
       
   }

   public function members($club) {
   		$this->security_check($club);	
   		$this->set('members',$this->Membership->loadHistory($club,$this->currentYear));
    	$this->set('club',$club);
   }


   public function addMember($club) {
      //$this->setAutorisedClubs();
      $this->security_check($club);
   	  $this->set('club',$club);
      if ($this->request->is('post')) {
         $this->request->data['User']['username_reset'] = $this->RandomGenerator->generateWord();
         $this->request->data['User']['password_reset'] = $this->RandomGenerator->generateWord();
         $this->User->set($this->request->data);
         if($this->User->validates() != true ){
            $this->Session->setFlash(__('Il y a une erreur dans votre formulaire !'));
            return;
         } else {
            if ($this->User->save()) {
               $this->Membership->set(array('Membership'=>array('year'=>$this->currentYear,'user_id'=>$this->User->getInsertId(),'club'=>$club,'is_secretary'=>0)));
               if($this->Membership->save()){
               	$this->Session->setFlash(__('Votre enregistrement a réussi !'));
               	$this->redirect('/ManageMembers/members/'.$club);
               }
               else $this->Session->setFlash(__('Error'));
            } else {
               $this->Session->setFlash(__('Error'));
            }
         }
      }
   }

   /**
    *
    *
    nom;prenom;
    nom1;prenom1;mail1
    nom1;prenom1;mail1

    *
    * Enter description here ...
    */

   public function uploadMembers($club,$isRetry=0) {
      //$this->setAutorisedClubs();
      $this->security_check($club);
   	  $this->set('club',$club);
   	  if ($this->request->is('post') && !$isRetry) {
         $membersCsv = $this->request->data['User']['members'];
         $clubSelected = $this->request->data['User']['club'];
         $memberRows = explode("\n",$membersCsv);
         $users = $this->extractUserFromCsv($membersCsv,$clubSelected);

         $isValid = true;

         foreach($users as &$user){
            $this->User->set(array('User'=>$user));
            if( $this->User->validates($this->getListOfFieldToValidate()) != true ){
               $user['error'] = $this->User->invalidFields();
               $isValid = false;
            }
            
         }
		
         if (!$isValid){
            $this->Session->setFlash(__('Il y a une erreur dans votre fichier !'));
         }
         $this->set("users",$users);//used to populate the list
         $this->set("isValid",$isValid); // to check if confirm button is enable or not
         $this->set("membersCsv",$membersCsv); // add in a hidden field for callback
         $this->set("clubSelected",$clubSelected); // add in a hidden field for callback
         $this->render("confirm_upload_members");
      } else if($this->request->is('get')){
        
      }
   }

   public function confirmUploadMembers($club){
      $this->security_check($club);
   	  $membersCsv = $this->request->data['User']['members'];
      $clubSelected = $this->request->data['User']['club'];
      $users = $this->extractUserFromCsv($membersCsv,$clubSelected);

      foreach ($users as &$user){
         $user['username_reset'] = $this->RandomGenerator->generateWord();
         $user['password_reset'] = $this->RandomGenerator->generateWord();
         $this->User->create();
         $this->User->set(array('User'=>$user));
         $this->User->save();
         $this->Membership->create();
         $this->Membership->set(array('Membership'=>array('year'=>$this->currentYear,'user_id'=>$this->User->getInsertId(),'club'=>$club,'is_secretary'=>0)));
         $this->Membership->save();
      }
	  //$this->User->saveAll($users);
      $this->redirect('/ManageMembers/members/'.$club);
   }

   public function download($club){
      $this->security_check($club);
   	  $this->layout='empty';
      //create a file
      $filename = "export_".date("Y.m.d").".csv";

      header('Content-type: application/csv');
      header('Content-Disposition: attachment; filename="'.$filename.'"');

      $members = $this->Membership->loadHistory($club,$this->currentYear);
      $this->set('members',$members);
   }

   public function fiche($club){
   	$this->security_check($club);
   }
   
   
   private function extractUserFromCsv($membersCsv,$clubSelected){
      $memberRows = explode("\n",$membersCsv);
      $users = array();
      foreach ($memberRows as $memberRow){
         $fields = explode(";",$memberRow);
         if(count($fields) > 9){
            $mappedfields = $this->mapToUserFields($fields);
            $mappedfields['club'] = $clubSelected;
            array_push($users, $mappedfields);
         }
      }
      return $users;
   }


   private function mapToUserFields($fields){
      $user['nom']= $fields[0];
      $user['prenom']= $fields[1];
      $user['date_naissance']= $fields[2];
      $user['lieu_de_naissance']= $fields[3];
      $user['sexe']=$fields[4];
      $user['adresse']= $fields[5];
      $user['code_postal']= $fields[6];
      $user['ville']= $fields[7];
      $user['mail']= $fields[8];
      $user['fixephone']= $fields[9];
      $user['gsm']=trim($fields[10]); // to evict \n
      return $user;
   }

   private function getListOfFieldToValidate(){
      $fieldList = array('fieldList' => array('nom','prenom','date_naissance','lieu_de_naissance','sexe','adresse','code_postal','ville','mail'));
      return $fieldList;
   }

   private function loadMembers($club){

      /*if($this->isManageAutorisationAllowed()){
         return  $this->User->find('all',array('order'=>'User.nom,User.prenom'));
      } else $this->redirect("/welcome/index");
      */
      if($this->isManageMemberAllowed()){
      	 if($this->Membership->isManageMemberAllowed($this->Session->read('Auth.User.id'),$club)){
      	 	return $this->User->find('all', array('conditions'=> array('User.club' => $club),
      	 									   'order'=>'User.nom,User.prenom'                                     
      	                                      )
      	                         );
      	 }
      	 else {
      	 	$this->Session->setFlash("Vous n'avez pas le droit de voir/changer les membres du ".$club."!");
      	 	$this->redirect("/welcome/index");
      	 }
      	 
      }

   }
   public function viewMember($club,$id){
   	    $this->security_check($club,$id);
   	    $this->set('club',$club);
   		$this->request->data= $this->User->findById($id);
   }
   public function editMember($club){
   	  $this->security_check($club);
   	  $data=$this->request->data;
   	  $this->User->set($data);
   	  if($this->User->validates() != true ){
            $this->Session->setFlash(__('Il y a une erreur dans votre formulaire !'));
            $this->render('view_member');
            return;
         } else {
            if ($this->User->save()) {
               $this->Session->setFlash(__('Votre enregistrement a réussi !'));
               $this->redirect('/ManageMembers/members/'.$club);
            } else {
               $this->Session->setFlash(__('Error'));
            }
         }
   }
   
   public function history_members($club){
  	   $this->security_check($club);
  	   for($i=$this->currentYear-5;$i<=$this->currentYear;$i++){
       		$history[$i]=$this->Membership->loadHistory($club,$i);
       	}
       $this->set('history',$history);
   }
   public function old_members_add($club){
   	   $this->security_check($club);
   	   //$users=$this->Membership->loadHistory($club,$this->currentYear-1);
   	   $users=$this->Membership->loadHistory($club,'all'); //get most recent memberships of all members within the history of the club
   	   foreach($users as &$user){
   	   	    $user['already_member']=$this->Membership->isMember($user['User']['id'],$club,$this->currentYear);
   	   }
   	   //$this->Session->setFlash(json_encode($users));
   	   $this->set('club',$club);
   	   $this->set('members',$users);
   }
   public function renew_old($club){
   	   $this->security_check($club);
   	   $this->Session->setFlash('R&eacute;inscription r&eacute;ussie!');
   	   $data=$this->data;
   	   foreach($data['add'] as $key=>$value){
   	   	if($value==1){
   	   		$this->Membership->create();
   	   		$this->Membership->set(array('Membership'=>array('year'=>$this->currentYear,'user_id'=>$key,'club'=>$club,'is_secretary'=>0)));
   	   		$this->Membership->save();
   	   	}
   	   }
   	   //$this->Session->setFlash(json_encode($this->data));
   	   $this->redirect("/ManageMembers/members/CRBK");
   }
   public function security_check($club,$id=0){
   		if(!($this->Membership->isManageMemberAllowed($this->Session->read('Auth.User.id'),$club,$this->currentYear))){
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