<?php 
App::import('Vendor','tcpdf/tcpdf');
App::import('Controller','App');
$tcpdf=new TCPDF();
$tcpdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );

foreach($licences as $licence){
	
	$tcpdf->SetMargins(18,20);
	$tcpdf->AddPage('P','A6');
	$tcpdf->SetPrintFooter(false);
	
	$tcpdf->SetLineStyle( array( 'width' => 0.5, 'color' => array(0,0,0)));
	
	$margins=$tcpdf->GetMargins();
	
	
	
	$paddingLeftRight=3;
	$paddingTopBottom=25;
	
	
	// top line
	$tcpdf->Line($margins['left']-$paddingLeftRight,$margins['top'],$tcpdf->getPageWidth()-$margins['right']+$paddingLeftRight,$margins['top']);
	//vertical right line  
	$tcpdf->Line($tcpdf->getPageWidth()-$margins['right']+$paddingLeftRight,$margins['top'],$tcpdf->getPageWidth()-$margins['right']+$paddingLeftRight,$tcpdf->getPageHeight()-$paddingTopBottom);
	// bottom line
	$tcpdf->Line($margins['left']-$paddingLeftRight,$tcpdf->getPageHeight()-$paddingTopBottom,$tcpdf->getPageWidth()-$margins['right']+$paddingLeftRight,$tcpdf->getPageHeight()-$paddingTopBottom);
	// vertical left line
	$tcpdf->Line($margins['left']-$paddingLeftRight,$margins['top'],$margins['left']-$paddingLeftRight,$tcpdf->getPageHeight()-$paddingTopBottom);

	$tcpdf->SetLineStyle(array('width'=>0));
	$federationGerman='BELGISCHE KONIGLICH KANU VERBAND';
	$federationDutch='KONINKLIJK BELGISCH KANOVERBOND';
	$tcpdf->setFont('times');
	$tcpdf->SetFillColor(255, 255, 255);
	$tcpdf->SetFontSize(9);
	$tcpdf->SetDrawColor(255,255,255);
	$tcpdf->MultiCell(37, 0, $federationGerman, 1, 'C', 0, 0, '', '', true, 0, false, true, 0);
	$tcpdf->MultiCell(37, 0, $federationDutch, 1, 'C', 0, 0, '', '', true, 0, false, true, 0);
	$tcpdf->Ln();
	
	$tcpdf->SetFont('timesB','U');
	$tcpdf->MultiCell(0,0,'FEDERATION ROYAL BELGE DE CANOE',1,'C',0,0,'','',true,0,false,true,0);
	$tcpdf->Ln();
	
	$tcpdf->SetFont('timesB','');
	$tcpdf->SetFillColor(0,0,0);
	$tcpdf->SetTextColor(255,255,255);
	$tcpdf->SetFontSize(14);
	$tcpdf->MultiCell(0,0,$licence['Membership']['year'],1,'C',1,0,'','', true,0, false, true, 0);
	
	
	$tcpdf->SetTextColor(0,0,0);
	$tcpdf->SetDrawColor(0,0,0);
	$tcpdf->SetFont('times','');
	$tcpdf->Ln();
	$tcpdf->SetFontSize(10);
	$tcpdf->MultiCell(0,0,'Nom/Naam/Name',0,'C');
	
	$identification=strtoupper($licence['User']['nom']).' '.$licence['User']['prenom'];
	$tcpdf->SetFontSize(12);
	$tcpdf->MultiCell(0,0,$identification,0,'C',0,0,'','',true,0,false,true,0);
		
	$tcpdf->SetFontSize(10);
	$tcpdf->Ln();
	$tcpdf->MultiCell(0,0,'Lieu de naissance/Geboorteplaats/Geburtsort',0,'C');
	$tcpdf->SetFontSize(12);
	$tcpdf->MultiCell(0,0,strtoupper($licence['User']['lieu_de_naissance']),1,'C');
	$tcpdf->SetFontSize(10);
	$tcpdf->MultiCell(0,0,'Le/Op/Am',0,'C');
	$tcpdf->SetFontSize(12);
	$tcpdf->MultiCell(0,0,date('d/m/Y',strtotime($licence['User']['date_naissance'])),1,'C');
	$tcpdf->Ln();
	
	$tcpdf->SetFontSize(10);
	$tcpdf->MultiCell(0,0,'Club',0,'C');
	$tcpdf->SetFontSize(14);
	$tcpdf->MultiCell(0,0,$licence['Membership']['club'],1,'C');
	
	$tcpdf->Ln();
	$tcpdf->SetFont('timesB');
	$tcpdf->SetFontSize(11);
	$tcpdf->MultiCell(0,0,'LICENCE/VERGUNNING/LICENZ',0,'C');
	
	$licenceType=($licence['Membership']['l_type']=='Tourisme')?'Pratiquant':'Compétition';
	$tcpdf->SetFont('times');
	$tcpdf->MultiCell(0,0,$licenceType . ': ' . $licence['User']['ffc_id'].'/'.$licence['Membership']['l_yearly_number'],0,'C');
 	
 	
	$tcpdf->SetFontSize(12);
	if($licence['Membership']['l_type']=='Competition'||$licence['Membership']['l_type']=='Disciplines'){
	$tcpdf->SetFontSize(12);
	$tcpdf->MultiCell(0,0,'Catégorie: '.$licence['Membership']['category'].' '.$licence['User']['sexe'],0,'C');
	}
	else{
		$tcpdf->Ln();
	}
	$tcpdf->SetFontSize(8);
	
	if($licence['Membership']['l_type']=='Disciplines'){
		$tcpdf->MultiCell(0,0,AppController::getLicenceString($licence['Membership']),0,'C');
	}
	else{
		$tcpdf->Ln();
	}
	$tcpdf->SetFontSize(10);
	$tcpdf->MultiCell(0,0,'Le secrétaire sportif',0,'L');
	
	
	
}




$tcpdf->Output('licence_'.date('Y').'_'.date('m').'_'.date('d').'_'.date('H').'_'.date('i').'.pdf','D');

?>