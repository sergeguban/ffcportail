<?php
App::import('Vendor','tcpdf/tcpdf');
$tcpdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$tcpdf->SetCreator(PDF_CREATOR);
$tcpdf->SetAuthor('Fédération Francophone de Canoë');
$tcpdf->SetTitle('FFC_Rapports');
$tcpdf->SetSubject('Rapports annuels');
$tcpdf->SetKeywords('FFC');

// set default header data
$tcpdf->SetHeaderData(null, null, 'Fédération Francophone de Canoë','Rapports '. date('d').'/'.date('m').'/'.date('Y'));

// set header and footer fonts
$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//	require_once(dirname(__FILE__).'/lang/eng.php');
//	$tcpdf->setLanguageArray($l);
//}

// ---------------------------------------------------------

if(isset($stats)){
	foreach($years as $year){
		if(array_keys($stats)[0]!='FFC'){
			$tcpdf->AddPage();
			$tcpdf->SetFont('','BU',14);
			$tcpdf->Write(8,'Statistiques '.$year,'',false,'C');
			$tcpdf->Ln();
		}
		$mod=0;
		foreach($stats as $k=>$v){
			//debug($v);
			
			if($k=='FFC'){
				$tcpdf->AddPage();
				$tcpdf->SetFont('','BU',14);
				$tcpdf->Write(8,'Statistiques FFC '.$year,'',false,'C');
				$tcpdf->Ln();		
			}elseif($mod!=0 && $mod%3==0)$tcpdf->AddPage();
			$mod++;
			if($k!='FFC'){
				$tcpdf->SetFont('','BU',12);
				$tcpdf->Write(8,'Statistiques '.$k);
				$tcpdf->Ln();
			}
			/*
			$tcpdf->SetFont('','I',10);
			$tcpdf->Write(8,'Nombre total de membres: ');
			$tcpdf->SetFont('','',10);
			$tcpdf->Write(8,$v[$year]['gender_total']['men']+$v[$year]['gender_total']['women']);
			$tcpdf->Ln();
			$tcpdf->SetFont('','I',10);
			$tcpdf->Write(8,'Nombre total de femmes: ');
			$tcpdf->SetFont('','',10);
			$tcpdf->Write(8,$v[$year]['gender_total']['women']);
			$tcpdf->SetFont('','I',10);
			$tcpdf->Write(8,'           Nombre total d\'hommes: ');
			$tcpdf->SetFont('','',10);
			$tcpdf->Write(8,$v[$year]['gender_total']['men']);
			$tcpdf->Ln(); */
			
			
			
			$tcpdf->SetFont('','I',10);
			$tcpdf->WriteHTML('<p>&nbsp;Membres par tranche d\'&acirc;ge:<p>',0);
				
			
			$tcpdf->SetFont('','',10);
			$header = array('Sexe','Moins de 12 ans','Moins de 18 ans','Moins de 25 ans','Moins de 35 ans','Plus de 35 ans','Total');
			$w = array(.05,.18,.18,.18,.18,.18,.05);
			$tw = $tcpdf->GetPageWidth() -$tcpdf->getMargins()['left']-$tcpdf->getMargins()['right'];
			//debug($tcpdf->GetPageWidth());
				
			$tcpdf->SetFillColor(224, 235, 255);
			$num_headers = count($header);
			for($i = 0; $i < $num_headers; ++$i) {
				$tcpdf->Cell($w[$i]*$tw, 7, $header[$i], 1, 0, 'C', 1);
			}
			$tcpdf->Ln();
			
			// Color and font restoration
			$tcpdf->SetFillColor(224, 235, 255);
			$tcpdf->SetTextColor(0);
			$tcpdf->SetFont('');
			// Data
			
			$h=4;
			$tcpdf->Cell($w[0]*$tw,$h,'H','LR',0,'C');
			$i=1;
			foreach($v[$year]['age_total']['men'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'LR',0,'R');
				$i++;
			}
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['age_total']['men']),'LR',0,'R');
			
			$tcpdf->Ln();
			$tcpdf->Cell($w[0]*$tw,$h,'F','BLR',0,'C');
			$i=1;
			foreach($v[$year]['age_total']['women'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'BLR',0,'R');
				$i++;
			}
			
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['age_total']['women']),'BLR',0,'R');
				
			$tcpdf->Ln();
			$tcpdf->Cell($w[0]*$tw,$h,'Tous','LR',0,'C',1);
			$i=1;
			foreach($v[$year]['age_total']['all'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'LR',0,'R',1);
				$i++;
			}
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['age_total']['all']),'LR',0,'R',1);
			$tcpdf->Ln();
			$tcpdf->Cell($tw, 0, '', 'T');
			$tcpdf->Ln();
			
			$tcpdf->SetFont('','I',10);
			$tcpdf->WriteHTML('<p>&nbsp;Comp&eacute;titeurs par cat&eacute;gorie:<p>',0);
				
			$tcpdf->SetFont('','',10);
			$header = array('Sexe','Pupil','Minime','Cadet','Aspirant','Junior','Sénior','Vétéran 1','Vétéran 2','Vétéran 3','Total');
			$w = array(.05,.1,.1,.1,.1,.1,.1,.1,.1,.1,.05);
			$tw = $tcpdf->GetPageWidth() -$tcpdf->getMargins()['left']-$tcpdf->getMargins()['right'];
				
				
			$tcpdf->SetFillColor(224, 235, 255);
			$num_headers = count($header);
			for($i = 0; $i < $num_headers; ++$i) {
				$tcpdf->Cell($w[$i]*$tw, 7, $header[$i], 1, 0, 'C', 1);
			}
			$tcpdf->Ln();
				
			// Color and font restoration
			$tcpdf->SetFillColor(224, 235, 255);
			$tcpdf->SetTextColor(0);
			$tcpdf->SetFont('');
			// Data
				
			$h=4;
			$tcpdf->Cell($w[0]*$tw,$h,'H','LR',0,'C');
			$i=1;
			foreach($v[$year]['comp_total']['men'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'LR',0,'R');
				$i++;
			}
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['comp_total']['men']),'LR',0,'R');
			$tcpdf->Ln();
			$tcpdf->Cell($w[0]*$tw,$h,'F','BLR',0,'C');
			$i=1;
			foreach($v[$year]['comp_total']['women'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'BLR',0,'R');
				$i++;
			}
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['comp_total']['women']),'BLR',0,'R');
				
			$tcpdf->Ln();
			$tcpdf->Cell($w[0]*$tw,$h,'Tous','LR',0,'C',1);
			$i=1;
			foreach($v[$year]['comp_total']['all'] as $stat){
				$tcpdf->Cell($w[$i]*$tw,$h,$stat,'LR',0,'R',1);
				$i++;
			}
			$tcpdf->Cell($w[$num_headers-1]*$tw,$h,array_sum($v[$year]['comp_total']['all']),'BLR',0,'R',1);
				
			$tcpdf->Ln();
			$tcpdf->Cell($tw, 0, '', 'T');
			$tcpdf->Ln();
			
			$tcpdf->Ln();
			
		}
		
		
	}
	
	if($his){
		if(array_keys($stats)[0]!='FFC'){
			$tcpdf->AddPage();
			$tcpdf->SetFont('','BU',14);
			$tcpdf->Write(8,'Historiques','',false,'C');
			$tcpdf->Ln();
		}
		$mod=0;
		foreach($stats as $k=>$v){
			//debug($v);
				
			if($k=='FFC'){
				$tcpdf->AddPage();
				$tcpdf->SetFont('','BU',14);
				$tcpdf->Write(8,'Historique FFC','',false,'C');
				$tcpdf->Ln();
			}elseif($mod!=0 && $mod%2==0)$tcpdf->AddPage();
			$mod++;
			if($k!='FFC'){
				$tcpdf->SetFont('','BU',12);
				$tcpdf->Write(8,'Historique '.$k);
				$tcpdf->Ln();
			}
			/*
			 $tcpdf->SetFont('','I',10);
			 $tcpdf->Write(8,'Nombre total de membres: ');
			 $tcpdf->SetFont('','',10);
			 $tcpdf->Write(8,$v[$year]['gender_total']['men']+$v[$year]['gender_total']['women']);
			 $tcpdf->Ln();
			 $tcpdf->SetFont('','I',10);
			 $tcpdf->Write(8,'Nombre total de femmes: ');
			 $tcpdf->SetFont('','',10);
			 $tcpdf->Write(8,$v[$year]['gender_total']['women']);
			 $tcpdf->SetFont('','I',10);
			 $tcpdf->Write(8,'           Nombre total d\'hommes: ');
			 $tcpdf->SetFont('','',10);
			 $tcpdf->Write(8,$v[$year]['gender_total']['men']);
			 $tcpdf->Ln(); */
				
				
				
			$tcpdf->SetFont('','I',10);
			$tcpdf->WriteHTML('<p>&nbsp;Membres par tranche d\'&acirc;ge:<p>',0);
		
				
			$tcpdf->SetFont('','',10);
			$header = array('Année','Hommes','Femmes','Total');
			$w = array(.25,.25,.25,.25);
			$tw = $tcpdf->GetPageWidth() -$tcpdf->getMargins()['left']-$tcpdf->getMargins()['right'];
			//debug($tcpdf->GetPageWidth());
		
			$tcpdf->SetFillColor(224, 235, 255);
			$num_headers = count($header);
			for($i = 0; $i < $num_headers; ++$i) {
				$tcpdf->Cell($w[$i]*$tw, 7, $header[$i], 1, 0, 'C', 1);
			}
			$tcpdf->Ln();
				
			// Color and font restoration
			$tcpdf->SetFillColor(224, 235, 255);
			$tcpdf->SetTextColor(0);
			$tcpdf->SetFont('');
			// Data
			
			foreach($years_to_consider as $year){
				$h=4;
				$tcpdf->Cell($w[0]*$tw,$h,$year,'LR',0,'C');
				$stat = array_sum($v[$year]['age_total']['men']);
				$tcpdf->Cell($w[1]*$tw,$h,$stat,'LR',0,'C');
				$stat = array_sum($v[$year]['age_total']['women']);
				$tcpdf->Cell($w[2]*$tw,$h,$stat,'LR',0,'C');
				$stat = array_sum($v[$year]['age_total']['all']);
				$tcpdf->Cell($w[3]*$tw,$h,$stat,'LR',0,'C',1);
				$tcpdf->Ln();
				
			}
			$tcpdf->Cell($tw, 0, '', 'T');
			$tcpdf->Ln();
			$tcpdf->Ln();
				
				
			$tcpdf->SetFont('','I',10);
			$tcpdf->WriteHTML('<p>&nbsp;Comp&eacute;titeurs par cat&eacute;gorie:<p>',0);
		
			$tcpdf->SetFont('','',8);
			$header = array('Année','Pupil','Minime','Cadet','Aspirant','Junior','Sénior','Vétéran 1','Vétéran 2','Vétéran 3','Total');
			$w = array(.05,.1,.1,.1,.1,.1,.1,.1,.1,.1,.05);
				
			$tw = $tcpdf->GetPageWidth() -$tcpdf->getMargins()['left']-$tcpdf->getMargins()['right'];
		
		
			$tcpdf->SetFillColor(224, 235, 255);
			$num_headers = count($header);
			for($i = 0; $i < $num_headers; ++$i) {
				$tcpdf->Cell($w[$i]*$tw, 7, $header[$i], 1, 0, 'C', 1);
			}
			$tcpdf->Ln();
			$tcpdf->SetFont('','',10);
				
		
			// Color and font restoration
			$tcpdf->SetFillColor(224, 235, 255);
			$tcpdf->SetTextColor(0);
			$tcpdf->SetFont('');
			// Data
		
			foreach($years_to_consider as $year){
				$h=4;
				$tcpdf->Cell($w[0]*$tw,$h,$year,'LR',0,'C');
				$i=1;
				foreach($v[$year]['comp_total']['all'] as $stat){
					$tcpdf->Cell($w[$i]*$tw,$h,$stat,'LR',0,'C');
					$i++;
				}
				
				$stat = array_sum($v[$year]['comp_total']['all']);
				$tcpdf->Cell($w[$num_headers-1]*$tw,$h,$stat,'LR',0,'C',1);
				
				
				$tcpdf->Ln();
			}
			$tcpdf->Cell($tw, 0, '', 'T');
			$tcpdf->Ln();
			
				
		}
				
	}
	
	
	
	
}
$tcpdf->Output('Rapports_'.date('Y').'_'.date('m').'_'.date('d').'_'.date('H').'_'.date('i').'.pdf','D');

?>
