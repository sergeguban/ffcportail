<HTML>
<head>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
echo  $this->Html->css('messages');
?>
</head>
<body class="noBg">
<?php
 $this->MessagesListViewer->viewMessages($messages,$this->Html->url('/Messagerie/viewMessage',true),"message",$messageId);
?>

</body>
</HTML>
