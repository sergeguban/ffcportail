<?php echo $this->element('member',array('user'=>$user));?>
<?php 
 echo $this->Form->create(null, array('url'=> array('controller'=>'Consultation',
                                             'action' => 'clubs'))); 
 echo $this->Form->submit('Retour au clubs');
 echo $this->Form->end(); 
?>