<?php App::import('Controller','App');?>
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
<h2>Licences <?php echo $currentYear;?></h2>

<p>Vous êtes arbitre ou administrateur de la FFC</p>
<p>Vous avez la possibilité de consulter la liste des compétiteurs de la FFC</p>


<?php 
 echo $this->Form->create(null, array('url'=> array('controller'=>'Consultation',
                                             'action' => 'downloadPdf'))); 
 echo $this->Form->submit('Télécharger le pdf');
 echo $this->Form->end(); 
?>

<table class="tablesorter">
  <thead> 
    <tr> 
       <th>Nom</th> <th>Prénom</th><th>Catégorie</th><th>Discipline</th><th>Date Naissance</th><th>Club</th><th>Licence</th>
    </tr> 
 </thead>
 
 
  <?php  
     $colored='odd';
     foreach ($licencesCompetition as $licenceProduced){
  
  ?>
 
  <tr class="<?php echo $colored?>">
    <td><?php echo  $licenceProduced['User']['nom']?></td>
    <td><?php echo  $licenceProduced['User']['prenom']?></td>
    <td><?php echo  $licenceProduced['Membership']['category']?></td>
    <td><?php  echo AppController::getLicenceString($licenceProduced['Membership'])?></td>
    <td><?php echo  $licenceProduced['User']['date_naissance']?></td>
    <td><?php echo  $licenceProduced['Membership']['club']?></td>
    <td><?php echo $licenceProduced['User']['ffc_id']."/".$licenceProduced['Membership']['l_yearly_number']?></td>
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



