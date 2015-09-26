<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="/crbk/_styles/styles.css" rel="stylesheet" type="text/css">
<STYLE type="text/css">
<!--
BODY {
	background-image: none;
}
-->
</STYLE>
<SCRIPT language="javascript" src="/crbk/_scripts/macromedia.js"></SCRIPT>
</HEAD>

<body>
<form method="post" action="/ffcportail/Messagerie/addInscriptionList"
	accept-charset="iso-8859-1">
<DIV id="message">
<DIV id="text">
<?php 
echo $form->hidden('Message.id');
echo $form->hidden('Message.type');
?>
<INPUT type="submit" name="send" value="Ajouter une liste">
	<?php echo $form->input('Inscription.description', array('size'=>'60','label'=>false,'error' => array('wrap' => 'p', 'class' => 'error')))?>
</DIV>
</DIV>
</FORM>

</body>
</HTML>
