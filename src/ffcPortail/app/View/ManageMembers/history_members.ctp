<script>
  
   $(function() { 
      
      // call the tablesorter plugin 
      $(".tablesorter").tablesorter({ 
     
        // initialize zebra striping and filter widgets 
        widgets: ["zebra", "filter"], 
     
        //headers: { 0: { sorter: false, filter: false } }, 
     
        widgetOptions : { 
     
          // css class applied to the table row containing the filters & the inputs within that row 
          filter_cssFilter : 'tablesorter-filter', 
     
          // filter widget: If there are child rows in the table (rows with class name from "cssChildRow" option) 
          // and this option is true and a match is found anywhere in the child row, then it will make that row 
          // visible; default is false 
          filter_childRows : false, 
     
          // Set this option to true to use the filter to find text from the start of the column 
          // So typing in "a" will find "albert" but not "frank", both have a's; default is false 
          filter_startsWith : false 
     
        } 
     
      }); 
     
    });
   
   </script>
<?php for($i=Date('Y')-4;$i<=Date('Y');$i++){?>
	<table class="form" width="1200">
	<tr><td><strong>Membres <?php echo $i;?></strong></td></tr>
	<tr>
		<td><strong>Nombre de membres : </strong><?php echo count($history[$i])?></td>
	</tr>
	<tr>
		<td colspan=2>
			<div style="display:none" id=<?php echo 'moreInfoDisplay'.$i?>>
				<table class="tablesorter" >
				  <thead> 
				    <tr> 
				     <th>FFC identifiant</th>
				     <th>Nom</th>  <th>Prénom</th> <th>Date naissance</th><th>Lieu de naissance</th><th>Sexe</th><th>Adresse</th><th>Code postal</th><th>Ville</th>
				     <th>Mail</th><th>Téléphone fixe</th><th>Gsm</th>
				    </tr> 
				 </thead>
				 <?php  
				     $colored='odd';
				     foreach ($history[$i] as $member){
				  ?>
				 
				  <tr class="<?php echo $colored?>"  >
				  	<td><strong><?php echo  $member['User']['ffc_id']?></strong></td>
				    <td><?php echo  $member['User']['nom']?></td>
				    <td><?php echo  $member['User']['prenom']?></td>
				    <td><?php echo  $member['User']['date_naissance']?></td>
				    <td><?php echo  $member['User']['lieu_de_naissance']?></td>
				    <td><?php echo  $member['User']['sexe']?></td>
				    <td><?php echo  $member['User']['adresse']?></td>
				    <td><?php echo  $member['User']['code_postal']?></td>
				    <td><?php echo  $member['User']['ville']?></td>
				    <td><?php echo  $member['User']['mail']?></td>
				    <td><?php echo  $member['User']['fixephone']?></td>
				    <td><?php echo  $member['User']['gsm']?></td>
				   
				    
				    </tr>
				  
				  <?php 
				  if ($colored == 'odd'){
				      $colored='even';
				  } else {
				      $colored='odd';
				  }
				  
				     }
				  ?>
				 
				  
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td><a class='moreInfo' style='cursor: pointer' id=<?php echo '\''.$i.'\''?>>&#9660;Plus d'info</a></td>
	</tr>
	
</table>
<script>
	document.getElementById(<?php echo '\''.$i.'\'';?>).addEventListener("click", function(){moreInfo(<?php echo '\''.$i.'\'';?>)}, false);
	function moreInfo(id){
		if(document.getElementById('moreInfoDisplay'+id).style.display=='none'){
			$('#moreInfoDisplay'+id).slideDown(1000);
	        document.getElementById(id).innerHTML='&#9650;Cacher';
		}
		else{
			document.getElementById(id).innerHTML='&#9660;Plus d\'info';
			$('#moreInfoDisplay'+id).slideUp(1000);
		}
	}
</script>
	
<?php }?>
