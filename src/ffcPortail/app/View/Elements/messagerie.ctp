
<LINK
	href="/crbk/_styles/messages.css" rel="stylesheet" type="text/css">

<DIV id="blockContent">
<TABLE id="tableContent" width="95%" cellpadding="0" cellspacing="0"
	align="center"
	style="background-image: url(/crbk/_img/headerMessagerie.gif)">
	<TR>
		<TD id="sectionMenu">

		<UL id="submenu">
		<?php
		if(isset($subMenus)){
		foreach ($subMenus as $subMenu) {?>
			<?php if($subMenu[2]){?>
			<LI class="focus"><?php echo $subMenu[0] ?></LI>
			<?php } else {?>
			<LI><A href="<?php echo $subMenu[1]?>"><?php echo $subMenu[0] ?></A></LI>
			<?php }?>
		<?php 
		}
		}
		?>
		</UL>
		</TD>

		<TD class="content"><?php  echo $content_for_layout; ?></TD>
	</TR>
</TABLE>
</DIV>
