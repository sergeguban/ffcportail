<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $uses= array('Membership');
	
	public $currentYear = 2022;

	public $components = array(
        'Session','Acl',
        'Auth' => array(
            'loginAction' => array('controller' => 'welcome', 'action' => 'index'),
            'loginRedirect' => array('controller' => 'welcome', 'action' => 'viewMyDossier'),
            'logoutRedirect' => array('controller' => 'welcome', 'action' => 'index')
	)
	);
	
	


	public function beforeRender(){
		$this->set('currentYear',$this->currentYear);
		$this->set('isUserLogged',$this->Auth->loggedIn());
		if($this->Auth->loggedIn()){
			
			$roles = $this->getRolesForUserId($this->Session->read('Auth.User.id'));

			$this->set('user',$this->Auth->user());
			$id=$this->Session->read('Auth.User.id');
			$memberships=$this->Membership->getMembershipsByUserByYear($id,$this->currentYear);
			$this->set('memberships',$memberships);
			
			$menu = array( array("Mes données",array('controller'=>'Welcome','action'=>'viewMyDossier'), $this->params['action'] == 'viewMyDossier'));
			if($this->isManageMemberAllowed() ){
				
				
				foreach($memberships as $membership){
					if($membership['Membership']['is_secretary']==1){
						$args=$this->params['pass'];
						array_push($menu, 
						array("Gestion ".$membership['Membership']['club'],array('controller'=>'ManageMembers','action'=>'members',$membership['Membership']['club']),
						$this->params['controller']=='ManageMembers'&&$args[0]==$membership['Membership']['club']));
					}
					
					
				}
				
				
				
				//array_push($menu,array("Gestion Club","/ManageMembers/members",$this->params['controller'] == 'ManageMembers'));
			}
			if($this->isManageLicenceAllowed() ){
				array_push($menu,array("Gestion FFC",array('controller'=>'ManageLicences','action'=>'licence'),$this->params['controller'] == 'ManageLicences'));
			}
			if($this->isConsultationAllowed() ){
				array_push($menu,array("Consultation",array('controller'=>'Consultation','action'=>'index'),$this->params['controller'] == 'Consultation'));
			}if($this->isManageAutorisationAllowed() ){
				array_push($menu,array("Gestion Admin",array('controller'=>'Autorisation','action'=>'index'),$this->params['controller'] == 'Autorisation'));
			}
			//  if($this->hasAccessMessagerie() ){
			array_push($menu,array("Messagerie",array('controller'=>'Messagerie','action'=>'index'),$this->params['controller'] == 'Messagerie'));
			//  }



			$this->set('menu',$menu);
			$this->set('roles',$roles);

		}
	}

	private function getRolesForUserId($userId){
		$aroacos = $this->Acl->Aro->findAllByModelAndForeignKey('User',$userId);
		$parentIds = array();
		foreach ($aroacos as $aroaco) {
			$aroaco['Aro']['parent_id'] ;
			array_push($parentIds, $aroaco['Aro']['parent_id']);
		}
		$result = $this->Acl->Aro->findAllById($parentIds);
		$roles = array();
		foreach ($result as $item) {
			$aroaco['Aro']['parent_id'] ;
			array_push($roles, $item['Aro']['alias']);
		}

		return $roles;

	}
	
	public function getLicenceString($membership){
		$string = '';
		if($membership['l_type']=='Competition')$string='Compétition';
		else if($membership['l_type']=='Tourisme')$string='Tourisme';
		else{
			$string = (($membership['l_downriver']?'descente, ':'').($membership['l_slalom']?'slalom, ':'').($membership['l_flatwater']?'course en ligne, ':'').($membership['l_marathon']?'marathon, ':'').($membership['l_polo']?'kayak-polo, ':''));
			$string = substr($string,0,-2);
		}
		
		return $string;
	}
	


	public function isUserInAcl($userId){
		$result = $this->Acl->Aro->findByForeignKey($userId);
		if($result == null){
			return false;
		}
		return true;
	}

	public function isManageLicenceAllowed(){
		return $this->checkAutorisation('manageLicence');
	}

	public function isConsultationAllowed(){
		return $this->checkAutorisation('consultation');
	}

	public function isManageAutorisationAllowed(){
		return $this->checkAutorisation('manageAutorisation');
	}

	public function isManageMemberAllowed(){
		return $this->checkAutorisation('manageMember');
	}


	public function hasAccessMessagerie(){
		return $this->checkAutorisation('accessMessagerie');
	}



	public function setAutorisedClubs(){
		if($this->isManageAutorisationAllowed() ){
			$clubs = $this->Club->find('list');
			$this->set('clubs',$clubs);
		} else  if($this->isManageMemberAllowed()){
			$userClub = $this->Session->read('Auth.User.club');
			$clubs = array("$userClub"=>"$userClub");
			$this->set('clubs',$clubs);
		}
	}

	/**
	 * check that user is in acl table or not
	 *
	 * if user is referenced in acl than check his autorisation
	 *
	 *
	 * Enter description here ...
	 * @param $autorisation
	 */
	private function checkAutorisation($autorisation){
		if(  $this->isUserInAcl($this->Session->read('Auth.User.id')) && 
		     $this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id') )), $autorisation) ){
			return true;
		} else {
			return false;
		}
	}

	private function isChildren($aliasInAro){
		$arbitre = $this->Acl->Aro->findByAlias($aliasInAro);
		$result= $this->Acl->Aro->findByParentIdAndForeignKey($arbitre["Aro"]["id"],$this->Session->read('Auth.User.id'));
	}

}
