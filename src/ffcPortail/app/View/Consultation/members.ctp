 <script>
  
   $(function() { 
      
      // call the tablesorter plugin 
      $(".tablesorter").tablesorter({ 
     
        // initialize zebra striping and filter widgets 
        widgets: ["zebra", "filter"], 
     
     
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


<h2>Membres FFC <?php echo $currentYear;?></h2>

<p>Vous êtes arbitre ou administrateur de la FFC</p>
<p>Vous avez la possibilité de consulter la liste de tout les membres de la FFC</p>


<?php 
 echo $this->Form->create(null, array('url'=> array('controller'=>'Consultation',
                                             'action' => 'downloadMembersPdf'))); 
 echo $this->Form->submit('Télécharger le pdf');
 echo $this->Form->end(); 
?>


<table class="tablesorter">
  <thead> 
    <tr> 
       <th>Nom</th> <th>Prénom</th><th>Date Naissance</th><th>FFC Id</th><th>Club</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     
     foreach ($members as $member){
  if($member['User']['ffc_id']!=NULL){
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $member['User']['nom']?></td>
    <td><?php echo  $member['User']['prenom']?></td>
    <td><?php echo  $member['User']['date_naissance']?></td>
    <td><?php echo  $member['User']['ffc_id']?></td>
    <td><?php echo  $member['Membership']['club']?></td>
  </tr>
  
  <?php 
  if ($colored == 'odd'){
      $colored='even';
  } else {
      $colored='odd';
  }
  }
     }
  ?>
</table>



