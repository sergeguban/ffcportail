<?php
class WelcomeController extends AppController {

   var $uses = array('Notification','User','Licence');

   public function beforeFilter() {
      $this->Auth->allow('index','index2');
   }

   public function beforeRender(){
      AppController::beforeRender();
   }



   public function index() {
      if($this->Auth->loggedIn()){
         $this->redirect('/welcome/viewMyDossier');   
      }
      $this->layout = 'notconnected';
   }
     
   
   


   public function viewMyDossier(){
      $this->layout = 'connected';
      
      $currentUserId = $this->Session->read('Auth.User.id');
      $freshUserData = $this->User->read(null, $currentUserId);
      unset($freshUserData['User']['password']);      
      $dataDto = array('User'=>$freshUserData['User']);

      $this->data = $dataDto;


      $findMyOk['conditions'] = array('user_id' =>  $currentUserId, 'status' => 'ok');
      $findMyWait['conditions'] = array('user_id' =>  $currentUserId, 'status' => 'wait');

      $findMyOk['order'] = array('Notification.created DESC');
      $findMyWait['order'] = array('Notification.created DESC');

      $notificationsOk   = $this->Notification->find('all',$findMyOk);
      $notificationsWait = $this->Notification->find('all',$findMyWait);
      
      $notificationsWaitList = array(
      		'admin'=>false,
      		'clubSecretaire'=>array(),
      		'arbitre'=>false,
      		'federalSecretaire'=>false
      );
      foreach($notificationsWait as $notificationWait){
      	    switch($notificationWait['Notification']['request']){
      	    	case 'admin':$notificationsWaitList['admin']=true;break;
      	    	case 'clubSecretaire':array_push($notificationsWaitList['clubSecretaire'],$notificationWait['Notification']['comment']);break;
      	    	case 'federalSecretaire':$notificationsWaitList['federalSecretaire']=true;break;
      	    	case 'arbitre':$notificationsWaitList['arbitre']=true;break;
      	    }
      }
      	
      $this->set('notificationsWait',$notificationsWait);
      $this->set('notificationsWaitList',$notificationsWaitList);
      $this->set('notificationsOk',$notificationsOk);
      
      $possible_competition_licences = array(
      		'slalom' => 'slalom',
      		'downriver' => 'descente',
      		'polo' => 'kayak-polo',
      		'marathon' => 'marathon',
      		'flatwater' => 'course en ligne'
      );
      $this->set('possible_competition_licences',$possible_competition_licences);
   }

   public function manageNotification($userId = -1){
      $this->layout = 'connected';
      if($userId != -1){ // display dossier
         $dossier = $this->User->findById($userId);
         $this->set('dossier', $dossier);
      }
      $notificationsWait = $this->Notification->getNotificationWaitWithUser();
      $this->set('notificationsWait',$notificationsWait);
   }


}

?>