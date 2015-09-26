<DIV id="blockContent">
<TABLE id="tableContent">
	<TR>
		<TD id="sectionMenu">

		<UL id="submenu">
		<?php
		if(isset($subMenu)){
		foreach ($subMenu as $itemMenu) {?>
			<?php if($itemMenu[2]){?>
			<LI class="focus"><?php echo $itemMenu[0] ?></LI>
			<?php } else {?>
			<LI> <?php  echo $this->Html->link($itemMenu[0],$itemMenu[1]) ?></LI>
       
			<?php }?>
		<?php 
		}
		}
		?>
		</UL>
		</TD>

		<TD class="content">
		   <?php  
		   echo $this->Session->flash();
		   echo $content_for_layout; 
		   ?>
        </TD>
 	</TR>
</TABLE>
</DIV>
