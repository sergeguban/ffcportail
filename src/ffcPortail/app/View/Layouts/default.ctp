<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
<div> 
	<?php
	if($isUserLogged){
		echo $user['username'];
        echo $this->Html->link('Logout', '/users/logout'); 
	} else {
	    echo $this->Html->link('Login', '/users/login'); 
	}

	?>
</div>
<div>
<?php echo $this->Html->link('Add users', '/users/add');?> 
<?php echo $this->Html->link('View', '/users/view');?> 
</div>		

		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">

		</div>
	</div>

</body>
</html>
