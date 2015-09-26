<?php
class UsersController extends AppController {
	
   
   public function beforeFilter() {
      $this->Auth->allow('login','logout','add');
      $this->Auth->authenticate = array('Form','AuthUserPasswordReset');
   }

   public function beforeRender(){
      $this->layout = 'notconnected';
   }

   public function login() {
      if ($this->request->is('post')) {
         if ($this->Auth->login()) {
            $this->redirect($this->Auth->redirect());
         } else {
            $this->Session->setFlash(__('Alias et/ou mot de passe ne sont pas valables!'));
            $this->redirect('/welcome/index');
         }
      }
   }

   private function _checkNormalAndResetlogin(){
      if ($this->Auth->login())  return true;
       
     // $this->User->find(array('conditions'=>array('username_reset'=> ) ))
       

   }
    
    
   public function logout() {
   	  $this->redirect($this->Auth->logout());
   }

   public function index() {
      $this->User->recursive = 0;
      $this->set('users', $this->paginate());
   }

   public function view() {

   }

   /**
    *
    * Receive datas
    * Array
    (
    [User] => Array
    (
    [nom] =>
    [prenom] =>
    [mail] =>
    [username] =>
    [password] =>
    [repeatPassword] =>
    )

    )
    *
    * Enter description here ...
    */
   public function add() {
      if ($this->request->is('post')) {

         if($this->data['User']['password'] != $this->data['User']['repeatPassword'] ){
            $this->Session->setFlash(__('Les mots de passe ne correspondent pas !'));
            return;
         }

         $this->User->set($this->request->data);
         if($this->User->validates() != true ){
            $this->Session->setFlash(__('Il y a une erreur dans votre formulaire !'));
            return;
         } else {
            if ($this->User->save($this->request->data)) {
               $this->Session->setFlash(__('Votre enregistrement a réussi, connectez vous !'));
               $this->redirect('/welcome/index');
            } else {
               $this->Session->setFlash(__(''));
            }
         }

      }
   }

   public function edit($id = null) {
      $this->User->id = $id;
      if (!$this->User->exists()) {
         throw new NotFoundException(__('Invalid user'));
      }

      $this->User->set($this->request->data);
      if($this->User->validates() != true ){
         $this->Session->setFlash(__('Il y a une erreur dans votre formulaire !'));
         $this->redirect('/welcome/viewMyDossier');
      }


      if ($this->request->is('post') || $this->request->is('put')) {
         if ($this->User->save($this->request->data['User'])) {
            $this->Session->setFlash(__('Vos données sont sauvées !'));
            $this->redirect('/welcome/viewMyDossier');
         } else {
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            $this->redirect('/welcome/viewMyDossier');
         }
      } else {
         $this->request->data = $this->User->read(null, $id);
         unset($this->request->data['User']['password']);
      }
   }

   public function saveNewPassword($id = null) {
      $this->User->id = $id;
      if (!$this->User->exists()) {
         throw new NotFoundException(__('Invalid user'));
      }

      $this->User->set($this->request->data);
      if($this->User->validates() != true ){
      	 $errors = $this->User->invalidFields();  
         if(isset($errors['username'])){
         	$this->Session->setFlash(__($errors['username'][0]));
         }
         else{
      	 	$this->Session->setFlash(__('Il y a une erreur dans votre formulaire !'));
         }
         $this->redirect('/welcome/viewMyDossier');
      }
      if($this->data['User']['password'] != $this->data['User']['repeatPassword'] ){
         $this->Session->setFlash(__('Les mots de passe ne correspondent pas !'));
         $this->redirect('/welcome/viewMyDossier');
         return;
      }

      if ($this->request->is('post') || $this->request->is('put')) {
         if ($this->User->save($this->request->data['User'])) {
            $this->Session->setFlash(__('Vos données sont sauvées !'));
            $this->redirect('/welcome/viewMyDossier');
         } else {
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            $this->redirect('/welcome/viewMyDossier');
         }
      } else {
         $this->request->data = $this->User->read(null, $id);
         unset($this->request->data['User']['password']);
      }

   }



   public function delete($id = null) {
      if (!$this->request->is('post')) {
         throw new MethodNotAllowedException();
      }
      $this->User->id = $id;
      if (!$this->User->exists()) {
         throw new NotFoundException(__('Invalid user'));
      }
      if ($this->User->delete()) {
         $this->Session->setFlash(__('User deleted'));
         $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash(__('User was not deleted'));
      $this->redirect(array('action' => 'index'));
   }
}
?>