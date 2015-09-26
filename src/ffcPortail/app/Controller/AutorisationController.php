<?php
/**
 *
 * USe this  to initialie
 *
 *
 *
 */

class AutorisationController extends AppController {

	var $uses = array('Notification','Aros','Membership');
	var  $components = array('Acl','Session');

	public function beforeFilter() {
		$this->Auth->authorize = array('Controller');
	}

	public function beforeRender(){
		AppController::beforeRender();
		$subMenu = array(
      			
		      array ("Autorisations",array('controller'=>'Autorisation','action'=>'index'),  $this->params['action'] == 'index'),
		      array ("Membres",array('controller'=>'Autorisation','action'=>'members'),$this->params['action'] == 'members')
		 	);
     	$this->set('subMenu',$subMenu);
		$this->layout = 'connected';
	}

	public  function isAuthorized(){
		 return $this->isManageAutorisationAllowed();
	}
	

	public function createAcl(){
		$aro = $this->Acl->Aro;
		$aro->create();$aro->save(array('alias'=>'clubSecretaire'));
		$aro->create();$aro->save(array('alias'=>'admin'));
		$aro->create();$aro->save(array('alias'=>'arbitre'));
		$aro->create();$aro->save(array('alias'=>'federalSecretaire'));

		$aco = $this->Acl->Aco;
		$aco->create();$aco->save(array('alias'=>'manageLicence'));
		$aco->create();$aco->save(array('alias'=>'manageAutorisation'));
		$aco->create();$aco->save(array('alias'=>'viewMember'));
		$aco->create();$aco->save(array('alias'=>'manageMember'));


		$this->Acl->allow('clubSecretaire', 'manageLicence');
		$this->Acl->allow('admin', 'admin');

	}
	 
	 
	public function index () {
		$autorisationsRequest = $this->Notification->getAllWaitingAutorisationsRequest();
		foreach($autorisationsRequest as &$autorisationRequest){
			if($autorisationRequest['Notification']['request']!='clubSecretaire'){
				$memberships=$this->Membership->getMembershipsByUserByYear($autorisationRequest['User']['id'],$this->currentYear);
				$autorisationRequest['Notification']['comment']='';
				foreach($memberships as $membership){
					$autorisationRequest['Notification']['comment'].=$membership['Membership']['club'].' ';
				}
			}
		}
		$this->set('autorisationsRequest', $autorisationsRequest);

		//$clubSecretaires= $this->Aros->getAllUsersForGroup('clubSecretaire');
		$clubSecretaires=$this->Membership->loadClubSecretaries($this->currentYear);
		$this->set('clubSecretaires',$clubSecretaires);

		$federalSecretaires = $this->Aros->getAllUsersForGroup('federalSecretaire');
		foreach($federalSecretaires as &$federalSecretaire){
			$memberships=$this->Membership->getMembershipsByUserByYear($federalSecretaire['User']['id'],$this->currentYear);
			$federalSecretaire['User']['club']='';
			$first=true;
			foreach($memberships as $membership){
				$federalSecretaire['User']['club'].=($first==true)?$membership['Membership']['club']:' - '.$membership['Membership']['club'];
				$first=false;
			}
		}
		$this->set('federalSecretaires',$federalSecretaires);

		$admins = $this->Aros->getAllUsersForGroup('admin');
		foreach($admins as &$admin){
			$memberships=$this->Membership->getMembershipsByUserByYear($admin['User']['id'],$this->currentYear);
			$admin['User']['club']='';
			$first=true;
			foreach($memberships as $membership){
				$admin['User']['club'].=($first==true)?$membership['Membership']['club']:' - '.$membership['Membership']['club'];
				$first=false;
			}
		}
		$this->set('admins',$admins);

	    $arbitres = $this->Aros->getAllUsersForGroup('arbitre');
		foreach($arbitres as &$arbitre){
			$memberships=$this->Membership->getMembershipsByUserByYear($arbitre['User']['id'],$this->currentYear);
			$arbitre['User']['club']='';
			$first=true;
			foreach($memberships as $membership){
				$arbitre['User']['club'].=($first==true)?$membership['Membership']['club']:' - '.$membership['Membership']['club'];
				$first=false;
			}
		}
		$this->set('arbitres',$arbitres);
		
	}

	public function valider ($notificationId) {
		$notification = $this->Notification->findById($notificationId);
		
		 
		$aro = $this->Acl->Aro;
		$role = $notification['Notification']['request']; // admin, arbitre ...
		$result =  $this->Acl->Aro->findByAlias($role);
		$isFirst=true;$membershipToChange=null;
		if($role=='clubSecretaire'){
			$memberships=$this->Membership->getMembershipsByUserByYear($notification['Notification']['user_id'],$this->currentYear);
			foreach($memberships as $membership){
				if($membership['Membership']['is_secretary']==1){
					$isFirst=false;
				}
				else if($membership['Membership']['club']==$notification['Notification']['comment']){
					$membershipToChange=$membership;
				}
				$this->Membership->save(array('id'=>$membershipToChange['Membership']['id'],'is_secretary'=>1));
			}
		}
		if( $result != null && $isFirst){
			$data = array(
				      'parent_id' => $result['Aro']['id'],
				      'model' => 'User',
				      'foreign_key' => $notification['Notification']['user_id']
			);
			$aro->create();
			$aro->save($data);
			
			
		}
		$notification['Notification']['status'] = 'ok';
		$notification['Notification']['user_id_responder'] = $this->Session->read('Auth.User.id') ;
		$this->Notification->save($notification);
		$this->redirect('/Autorisation/index');
	}
	 
	public function refuser($notificationId) {
		$notification = $this->Notification->findById($notificationId);
		$notification['Notification']['status'] = 'refuse';
		$notification['Notification']['response'] = 'votre demande a été refusée';
		$notification['Notification']['user_id_responder'] = $this->Session->read('Auth.User.id') ;
		 
		$this->Notification->save($notification);
		$this->redirect('/Autorisation/index');
	}

	 
	 
	public function revoke($id, $group){
		/*if $group is clubSecretaire, $id is Membership.id, else $id is User.id
		 * in case $clubSecretaire, only delete aro if last one
		 */
		
		if($group=='clubSecretaire'){
			$this_membership=$this->Membership->findById($id);
			$memberships=$this->Membership->getMembershipsByUserByYear($this_membership['User']['id'],$this->currentYear);
			$num_sec=0;
			foreach($memberships as $membership){
				if($membership['Membership']['is_secretary'])$num_sec++;
			}
			$this->Membership->save(array('id'=>$id,'is_secretary'=>0));
			if($num_sec==1){
				$aroIds = $this->Aros->getAroIdForUserInGroup($this_membership['User']['id'],$group);
				$aro = $this->Acl->Aro;
				$aro->delete($aroIds[0]['Aro']['id']);
			}
		}
		else{
			$aroIds = $this->Aros->getAroIdForUserInGroup($id,$group);
			$aro = $this->Acl->Aro;
			$aro->delete($aroIds[0]['Aro']['id']);
		}
		

		$this->redirect('/Autorisation/index');
	}
	public function members(){
		$members=$this->Membership->find('all',array('order'=>array('Membership.year DESC','Membership.club','User.nom')));
		foreach($members as &$member){
			$conditions = array(
    			'Membership.user_id' => $member['User']['id'],
   				'Membership.year' => $this->currentYear,
				'Membership.club' => $member['Membership']['club']
			);
			if ($this->Membership->hasAny($conditions)){
    			$member['Membership']['is_currently_member']=true;
			}else{
				$member['Membership']['is_currently_member']=false;
			}
		}
		$this->set('members',$members);
	}
	public function delete_licence($id){
		$this->Membership->save(array('id'=>$id,'licence'=>0));
		$this->redirect('/Autorisation/members');
	}
	public function remove_member($id){
		$this->Membership->delete(array('id'=>$id));
		$this->redirect('/Autorisation/members');
	}
	public function new_licence($id,$type){
		$this->Membership->save(array('id'=>$id,'licence'=>1,'l_created'=>$this->currentYear,'l_type'=>$type,'l_status'=>'validated'));
		$this->redirect('/Autorisation/members');
	}
	public function add_old_member($id){
		$old=$this->Membership->findById($id);
		$this->Membership->create();
		$this->Membership->save(array('user_id'=>$old['Membership']['user_id'],'year'=>$this->currentYear,'is_secretary'=>$old['Membership']['is_secretary'],'club'=>$old['Membership']['club']));
		$this->redirect('/Autorisation/members');
	}
	public function createRoles(){

		$this->redirect('/Autorisation/index');
	}


}

?>