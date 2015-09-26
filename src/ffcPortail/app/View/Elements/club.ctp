
<table class="form" width=1150px <?php if($club['acronyme']=='FFC'){echo "style='border-color:gray'";}?>>
	<tr>
		<td width=50%><strong>Acronyme : </strong><?php echo $club['acronyme']?></td>
		<td width=50% align='right'><strong>Nom : </strong><?php echo $club['description']?></td>
	</tr>
	<tr>
		<td><strong>Nombre de membres : </strong><?php echo $club['total']?></td>
		<td align='right'><strong>Nombre de comp&eacute;titeurs : </strong><?php echo array_sum($club['competitorsByCategory'])?></td>
	</tr>
	<tr>
		<td colspan=2>
			<div style="display:none" id=<?php echo 'moreInfoDisplay'.$club['acronyme']?>>
				<table>
					<tr>
						<td width=50%>
							<div id=<?php echo 'ageStructure'.$club['acronyme']?> style='height:350px;width:350px'></div>
						</td>
						<td width=50%>
							<div id=<?php echo 'competitorsStructure'.$club['acronyme']?> style='height:350px;width:700px;'></div>
						</td>
						
					</tr>
					<tr>
						
					</tr>
					<?php if($club['acronyme']!='FFC'){?>
					<tr>
						<td colspan=2>
							<ul>
								<li><strong>Secr&eacute;taires de club (<?php echo count($club['clubSecretaries'])?>): </strong><ul style='margin-left: 3em'>
								<?php foreach($club['clubSecretaries'] as $clubSecretary){
									echo '<li>'
									.$clubSecretary['User']['prenom']
									.' '
									.$clubSecretary['User']['nom']
									.'&nbsp;&nbsp;'
									.$this->Html->link('<img src="/ffcportail/ffcportail/img/info-icon.png" title="plus d\'info"></img>',array('controller' => 'Consultation','action'=>'viewResponsable',$clubSecretary['User']['id']),
                         array('escape' => false))
                         			.'</li>';
								}?>
								</ul>
								</li>
								<li><strong>Arbitres (<?php echo count($club['arbitres'])?>): </strong><ul style='margin-left: 3em'>
								<?php foreach($club['arbitres'] as $arbitre){
									echo '<li>'.$arbitre['User']['prenom'].' '.$arbitre['User']['nom'].'&nbsp;&nbsp;'
									.$this->Html->link('<img src="/ffcportail/ffcportail/img/info-icon.png" title="plus d\'info"></img>',array('controller' => 'Consultation','action'=>'viewResponsable',$arbitre['User']['id']),
                         array('escape' => false))
                        			 .'</li>';
								}?>
								</ul>
								</li>
							</ul>
						</td>
					</tr>
					<?php }else{?>
					<tr>
						<td colspan=2>
							<ul>
								<li><strong>Secr&eacute;taires de la f&eacute;d&eacute;ration (<?php echo count($club['federalSecretaries'])?>): </strong><ul style='margin-left: 3em'>
								<?php foreach($club['federalSecretaries'] as $federalSecretary){
									echo '<li>
									'.$federalSecretary['User']['prenom'].' '.$federalSecretary['User']['nom'].'    '.$federalSecretary['User']['club'].
									'&nbsp;&nbsp;'
									.$this->Html->link('<img src="/ffcportail/ffcportail/img/info-icon.png" title="plus d\'info"></img>',array('controller' => 'Consultation','action'=>'viewResponsable',$federalSecretary['User']['id']),
                         array('escape' => false))
									.'</li>';
									
									
								}?>
								</ul>
								</li>
							</ul>
						</td>
					</tr>
					<?php }?>
						
				</table>
				
				
			</div>
		</td>
	</tr>
	<tr>
		<td><a class='moreInfo' style='cursor: pointer' id=<?php echo '\''.$club['acronyme'].'\''?>>&#9660;Plus d'info</a></td>
	</tr>
	



</table>
<script>
	document.getElementById(<?php echo '\''.$club['acronyme'].'\'';?>).addEventListener("click", function(){moreInfo(<?php echo '\''.$club['acronyme'].'\'';?>)}, false);
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
	$('document').ready(function(){
		$('#<?php echo $club['acronyme'];?>').click(function(){
			var d1 = [];
			var totalByAge=<?php echo json_encode($club['totalByAge']);?>;
			for (var i = 0; i < 10; i++) {
				var number=totalByAge[i];
				d1.push([i*10, number]);
			}
			var totalCompetitorsByCategory=<?php echo json_encode($club['competitorsByCategory']);?>;
			var totalCompetitorsByCategoryFormatted=[];
			var j=0;
			for(i in totalCompetitorsByCategory){
				totalCompetitorsByCategoryFormatted.push([i,totalCompetitorsByCategory[i]]);
				j++;
			}
			$.plot(<?php echo "'#ageStructure".$club['acronyme']."'"?>, [ { 
				data: d1,
	            bars: {
	            	show: true,
	           		barWidth: 10,
	           		align: "center"
				},
				yaxis: {ticks: 10, min: 0},
				color:"green",
				label:'Nombre de membres'
			    }
	        ],{xaxis: {font:{size:13,color:"black"}},yaxis: {font:{size:13,color:"black"}}});
	        $.plot(<?php echo "'#competitorsStructure".$club['acronyme']."'"?>, [{
	            data: totalCompetitorsByCategoryFormatted,
	            bars: {show:true,barWidth:0.8,align:"center"},
	            color:"green",
	            label:"Nombre de compétiteurs",
	            yaxis: {min: 0}
	        }],{xaxis: {mode: "categories",font:{size:13,color:"black"}},yaxis: {font:{size:13,color:"black"}}});
			
		});
	});


	

--></script>