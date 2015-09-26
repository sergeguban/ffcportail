<?php
class MessagerieController extends AppController {

	var $name = 'Messagerie';
	var $uses = array('Message','MessageLu','User','InscriptionList','Inscription');
	var $helpers = array('Html', 'MessagesListViewer');
	var $components = array('Session');



	public function beforeFilter(){
		$this->layout = 'connected';


	}

	public function beforeRender(){
		AppController::beforeRender();
		$subMenu = $this->_getSubMenu();
		if($this->_isLayoutWithSubmenu())
		if($this->request->action == 'index'){
			$subMenu["allMessages"][2] = true;
		} else if($this->request->action == 'messages'){
			$subMenu[$this->request->params['pass'][0]][2] = true; // on passe en param le type de messsage (cr,cp ...)
		} else {
			$subMenu[$this->request->query['type']][2] = true; // on passe en param le type de messsage (cr,cp ...)
		};
		$this->set('subMenu', $subMenu);
	}

	function _isLayoutWithSubmenu(){
		if($this->request->action == 'messages' || $this->request->action == 'createNewMessage' || $this->request->action == 'updateMessage' ||  $this->request->action == 'index' ){
			return true;
		} else {
			return false;
		}

	}

	function _getSubMenu() {
		$subMenus = array("allMessages"=>array ("Aperçu","/Messagerie/index",false),
						  "dis"=>array ("Discussion","/Messagerie/messages/dis",false),
      				  "inf"=>array ("Information","/Messagerie/messages/inf",false)

		);
		return $subMenus;
	}



	function __messageReaded($messageId){
		$this->MessageLu->setMessageLu($messageId,$this->Session->read('Auth.User.id'));
	}

	function __getMessageLu(){
		if(!isset($this->viewVars["messageLu"])){
			$this->viewVars["messageLu"] = $this->MessageLu->findAllByUserId($this->Session->read('Auth.User.id'));
		}
		return $this->viewVars["messageLu"];
	}

	function __isMessageReaded($messageId){
		foreach ($this->viewVars["messageLu"] as $messageLu){
			if($messageLu["MessageLu"]["messageId"] == $messageId) {
				return true;
			}
		}
		return false;
	}

	function __setMessageReaded(&$messages){
			
	}

	function __loadMessage($messageType,$archive=0,$messageId = null){
		$conditions = array('conditions' => array('Message.type ' => "$messageType",'Message.archive' => $archive  ));
		if($archive == 1) {
			$conditions['conditions']['Message.message_root_id'] = $messageId;
		}
		//$messages = $this->Message->find("all",$conditions);
		
		$reader_user_id=$this->Session->read('Auth.User.id');
		$messages = $this->Message->getMessagesList($messageType,$reader_user_id);
		
		
		$this->__setMessageReaded($messages);
		return $messages;
	}

	function __isMemberConnectedOwnerOfThisMessage($message){
		if($message['user_id'] == $this->Session->read('Auth.User.id')){
			return true;
		}
		return false;
	}


	
	// SELECT * FROM `messages`left join message_lus on messages.id = message_lus.message_id and message_lus.user_id = 1 where messages.type = 'inf' 
	


	function index() {
		$this->set('messageType', "all");

		$allMessages['dis'] = array($this->__loadMessage("dis"),"Discussion");
		$allMessages['inf'] = array($this->__loadMessage("inf"),"Information");

		$this->set('allMessages', $allMessages);
	}
	function messages($messageType, $messageId = null, $archive=0) {
		$this->set('messageType', $messageType);
		$this->set('messageId', $messageId);
		$this->set('archive', $archive);
	}
	function messagesList($messageType, $messageId = null, $archive=0) {
		$this->layout="empty";
		$this->set('messages', $this->__loadMessage($messageType,$archive,$messageId));
		$this->set('messageId', $messageId);
		$this->set('archive', $archive);
	}
	function viewMessage($messageId = null) {
		$this->layout="empty";
		if ($messageId != null) {
			$message = $this->Message->findById($messageId);
			$this->request->data['Message'] = $message['Message']; // for create inscription list form
			$messageInscriptions = $this->__getInscription($messageId);
			$this->set('messageInscriptions',$messageInscriptions);
			$this->set('message', $message);
			$this->__messageReaded($messageId);
			$this->set("isCalenderDateDisplayed", false);

			if($message['Message']['type'] == "cal" && $message['Message']['id_parent'] == 0 ){
				$this->set("isCalenderDateDisplayed", true);
			}
			if($this->__isMemberConnectedOwnerOfThisMessage($message['Message'])){
				$this->set('isAllowedForDelete',true);
				$this->set('isAllowedForUpdate',true);
				$this->set('isAllowedForArchive',true);
			} else {
				$this->set('isAllowedForDelete',false);
				$this->set('isAllowedForUpdate',false);
				$this->set('isAllowedForArchive',false);
			}
			$this->set('isAllowedForRegisterInscription',true);
			$this->set('memberConnected', $this->Session->read('Auth.User'));

		}else{
			$this->set('message',null);
		}
	}


	function createNewMessage(){

		$message = array();
		$membre = $this->Session->read('Auth.User');
		// create a new message in response
		$message['id_parent']=$this->params['url']['id_parent'];
		$message['type']=$this->params['url']['type'];
		//$message['archive']=$this->params['url']['archive'];
		if ( !isset($this->params['url']['archive'])) {
			$message['archive']='0';
		} else {
			$message['archive']=$this->params['url']['archive'];
		}
		$message['message_date']= date("Y-m-d");
		$message['message_heure']= date("H:i:s");
		$message['user_id']= $this->Session->read('Auth.User.id');
		if(isset($this->params['url']['id_racine'])){
			$message['id_racine']=$this->params['url']['id_racine'];
		} else {
			$message['id_racine']=0;
		}
		$this->set("isCalenderDateDisplayed", false);

		if ($this->params['url']['type'] == "cal" && $this->params['url']['id_parent'] == 0){
			$this->set("isCalenderDateDisplayed", true);
			$year = $this->params['url']['year'];
			$month = $this->params['url']['month'];
			$day = $this->params['url']['day'];
			$message['calendar_start_date'] = $year ."-" .$month."-". $day;
			$message['calendar_end_date'] = $year ."-" .$month."-". $day;
		}
		$this->request->data['Message'] = $message;

		$this->set('membre',$membre);

		$this->set('messageType',$this->params['url']['type'] );
		$this->render("messageForm");
	}

	function updateMessage(){
		$messageId=$this->request->query['messageId'];
		$message = array();
		$membre = $this->Session->read('membre');
		$message = $this->Message->findById($messageId);
		$this->request->data = $message;
		$this->set('membre',$membre);
		// $this->set('membrePhotoUrl', $this->Membre->getMemberPhotoUrl($membre));
		$this->set('messageType',$this->params['url']['type']);
		$this->set("isCalenderDateDisplayed", false);
		if ($message['Message']['type'] == "cal" && $message['Message']['id_parent'] == 0){
			$this->set("isCalenderDateDisplayed", true);
		}
		$messageInscriptions = $this->__getInscription($messageId);
		$this->set('messageInscriptions',$messageInscriptions);
		$this->render("messageForm");
	}


	function postMessage(){
		$this->Message->set($this->request->data); // pour que le model puisse avoir des datas � valider
		if($this->Message->validates() == false ){
			$membre = $this->Session->read('Auth.User');
			$this->layout="default";
			$this->set('subLayout', 'messagerie');
			$this->set('messageType',$this->data['Message']['type']);
			$this->set('membre',$membre);
			$this->set("isCalenderDateDisplayed", false);
			if ($this->data['Message']['type'] == "cal" && $this->request->data['Message']['id_parent'] == 0){
				$this->set("isCalenderDateDisplayed", true);
			}
			$this->render("messageForm");
			return;
		}

		$this->layout="empty";
		if($this->data['Message']['id'] != null){
			//update a message
			$this->Message->save($this->data['Message']);
			$messageId = $this->data['Message']['id'] ;
		} else {
			$membre = $this->Session->read('membre');
			$this->request->data['Message']['message_date']=date("Y-m-d");
			$this->request->data['Message']['message_heure']=date("H:i:s");
			$this->request->data['Message']['id_membre']=$membre['id_membre'];

			$this->Message->save($this->data['Message']);
			$messageId = $this->Message->id;// this return the last inserted id
			if($this->request->data['Message']['id_parent'] == 0){
				$this->Message->setMessageRootId($messageId);
			}

		}
		$messageType=$this->data['Message']['type'];
		if($this->data['Message']['type']  == "cal" && $this->data['Message']['id_parent'] == 0 ){
			$year =  $this->data['Message']['calendar_start_date']['year'];
			$month =  $this->data['Message']['calendar_start_date']['month'];
			header("Location:/crbk/calendar/index/$year/$month");
			$this->_stop();
		}
		$this->redirect("/Messagerie/messages/$messageType/$messageId");
	}

	function effacerMessage(){
		$this->layout="empty";
		$messages = $this->Message->findAllByType($this->params['url']['type']);
		$messagesId = $this->getSubMessagesList($messages,$this->params['url']['id_message']);
		$this->Message->deleteAllId($messagesId);
		$this->set('messageType',$this->params['url']['type'] );
	}
	function archiveMessage(){
		$this->layout="empty";
		$type = $this->params['url']['type'];
		$messageId = $this->params['url']['id_message'];
		$this->Message->archiveMessageGroup($messageId);
		$this->set('messageType',$this->params['url']['type'] );
		$this->render("effacerMessage");
	}

	function addListForm($messageId, $messageType){
		$this->layout="empty";
		$data['Message']['id_message']= $messageId;
		$data['Message']['type']= $messageType;
		$this->data=$data;
	}


	function addInscriptionList(){
		if(!isset($this->data['InscriptionList']['isCourse'])){
			$this->request->data['InscriptionList']['isCourse']=0;
		}
		$messageId = $this->request->data["Message"]['id'];
		$this->request->data['InscriptionList']['message_id']=$messageId;
		$this->InscriptionList->save($this->request->data['InscriptionList']);
		$this->redirect("/messagerie/viewMessage/$messageId");
	}

	function deleteInscriptionList(){
		$this->InscriptionList->delete($this->data["InscriptionList"]["id"]);
		$messageId = $this->request->data["InscriptionList"]['id_message'];
		$this->redirect("/messagerie/viewMessage/$messageId");
	}
	function closeInscriptionList(){
		$this->InscriptionList->close($this->data["InscriptionList"]["id"],$this->data["InscriptionList"]['closed']);
		$messageId = $this->request->data["InscriptionList"]['id_message'];
		$this->redirect("/messagerie/viewMessage/$messageId");
	}


	function updateInscriptionDescription(){
		$this->InscriptionList->update($this->data["InscriptionList"]);
		$messageId = $this->request->data["InscriptionList"]['id_message'];
		$this->redirect("/messagerie/viewMessage/$messageId");
	}

	function register(){
		$this->request->data['user_id']=$this->Session->read('Auth.User.id');
		if($this->data['prenom'] != "" || $this->data['nom'] != "" ){
			$this->Inscription->save($this->data);
		}
		$messageId = $this->request->data['message_id'];
		$this->redirect("/messagerie/viewMessage/$messageId");
	}

	function unregister($id,$messageId){
		$this->Inscription->deleteInscription($id);
		$this->redirect("/messagerie/viewMessage/$messageId");
	}

	/**
	 * call by effacerMessage to get the list of message attached at one message
	 */
	function getSubMessagesList($messages,$messageId)
	{
		$subMessages[]= $messageId;
		foreach ($messages as $message){
			if ($message["Message"]["id_parent"] == $messageId) {
				$subSubMessages = $this->getSubMessagesList($messages,$message["Message"]['id']);
				$subMessages = array_merge($subMessages , $subSubMessages);
			}
		}
		return $subMessages;
	}

	function __getInscription($messageId){
		$inscriptionLists = $this->InscriptionList->findAllByMessageId($messageId);
		foreach ($inscriptionLists as &$inscriptionList) {
			$inscriptions = $this->Inscription->findAllByInscriptionListId($inscriptionList['InscriptionList']['id']);
			$inscriptions = $this->__isUserConnectedOwnerOfTheRegister($inscriptions);
			$inscriptionList['Inscription'] =$inscriptions;
		}
		return $inscriptionLists;
	}

	function __isUserConnectedOwnerOfTheRegister(&$inscriptions){
		$userId=$this->Session->read('Auth.User.id');
		foreach ($inscriptions as &$inscription) {
			if($inscription['Inscription']['user_id'] == $userId ){
				$inscription['Inscription']['isOwner'] = true;
			} else {
				$inscription['Inscription']['isOwner'] = false;
			}
		}
		return $inscriptions;
	}



}
?>