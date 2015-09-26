<?php
class NotificationsController extends AppController {

   var $components = array('Session','Auth');
   var $uses=array('Membership');

   public function beforeFilter() {
      $this->Auth->deny('add','addDelegateRoleRequest');
   }


   public function add() {

      //      print_r($this->request->data);
      //      echo "userid=" . $this->Session->read('Auth.User.id');

      $data = $this->request->data['notification'];
      $data['user_id'] = $this->Session->read('Auth.User.id');
      $data['status'] = 'wait';
      $this->Notification->create();
      if ($this->Notification->save($data)) {
         $this->Session->setFlash(__('Votre enregistrement a réussi, connectez vous !'));
         $this->redirect('/welcome/viewMyDossier');
      } else {
         $this->Session->setFlash(__('Votre enregistrement a échoué, contactez l\'administrateur du site.'));
      }
      $this->redirect('/welcome/viewMyDossier');

   }


   public function addAutorisationRequest() {

      $notifications = array();

      
      if (array_key_exists('admin',  $this->request->data['Notification']) && $this->request->data['Notification']['admin']){
         array_push($notifications, $this->createNotification('admin'));
      }

      $id=$this->Session->read('Auth.User.id');
      foreach($this->Membership->getMembershipsByUserByYear($id,date('Y')) as $membership){
      	if (array_key_exists('clubSecretaire',  $this->request->data)&& array_key_exists($membership['Membership']['club'],$this->request->data['clubSecretaire'])&&$this->request->data['clubSecretaire'][$membership['Membership']['club']]){
         	array_push($notifications, $this->createNotification('clubSecretaire',$membership['Membership']['club']));
      	}
      }
      if (array_key_exists('Notification',  $this->request->data)&&array_key_exists('federalSecretaire',  $this->request->data['Notification'])&& $this->request->data['Notification']['federalSecretaire']){
         array_push($notifications, $this->createNotification('federalSecretaire'));
      } 
      
      if (array_key_exists('Notification',  $this->request->data)&&array_key_exists('arbitre',  $this->request->data['Notification'])&& $this->request->data['Notification']['arbitre']){
         array_push($notifications, $this->createNotification('arbitre'));
      }
     
      $this->Notification->create();
      if ($this->Notification->saveAll($notifications)) {
         $this->Session->setFlash(__('Vos demandes d\'autorisations ont été enregistrée !'));
      } else {
         $this->Session->setFlash(__('Votre enregistrement a échoué, contactez l\'administrateur du site.'));
      }
      $this->redirect('/welcome/viewMyDossier');

   }
    

   private function createNotification($autorisationRequest,$autorisationComment=0){
      $data['user_id'] = $this->Session->read('Auth.User.id');
      $data['status'] = 'wait';
      $data['type'] = 'autorisation';
      $data['request'] = $autorisationRequest ;
      $data['comment'] = $autorisationComment ;
      return $data;
   }
    
    
}
?>