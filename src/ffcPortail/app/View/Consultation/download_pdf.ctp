<?php
App::import('Vendor','tcpdf/tcpdf');
$tcpdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$tcpdf->SetCreator(PDF_CREATOR);
$tcpdf->SetAuthor('Fédération Francophone de Canoë');
$tcpdf->SetTitle('Licences FFC ' . $currentYear);
$tcpdf->SetSubject('Liccence FFC');
$tcpdf->SetKeywords('Licences');

// set default header data
$tcpdf->SetHeaderData(null, null, 'Fédération Francophone de Canoë','Licences compétitions ' . $currentYear .  ' - liste au '. date('d').'/'.date('m').'/'.date('Y') . ' (' . count($licencesProduced)  . ' licences )');

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

// set font
$tcpdf->SetFont('helvetica', '', 8);

// add a page
$tcpdf->AddPage();

$header = array('Nom','Prénom','Date Naissance', 'Catégorie','Club','Licence');

$tcpdf->SetFillColor(200);
$tcpdf->SetTextColor(255);
$tcpdf->SetDrawColor(128, 0, 0);
$tcpdf->SetLineWidth(0.3);
$tcpdf->SetFont('', 'B', 8);
// Header
$w = array(30, 30,25,20, 15, 15);
$num_headers = count($header);
for($i = 0; $i < $num_headers; ++$i) {
	$tcpdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
}
$tcpdf->Ln();
// Color and font restoration
$tcpdf->SetFillColor(224, 235, 255);
$tcpdf->SetTextColor(0);
$tcpdf->SetFont('');
// Data
$fill = 0;
$h=4;
foreach ($licencesProduced as $licenceProduced){
		
	$tcpdf->Cell($w[0], $h, $licenceProduced['User']['nom'], 'LR', 0, 'L', $fill);
	$tcpdf->Cell($w[1], $h, $licenceProduced['User']['prenom'], 'LR', 0, 'L', $fill);
	$tcpdf->Cell($w[2], $h, $licenceProduced['User']['date_naissance'], 'LR', 0, 'L', $fill);
	$tcpdf->Cell($w[3], $h, $licenceProduced['Membership']['category'], 'LR', 0, 'R', $fill);
	$tcpdf->Cell($w[4], $h, $licenceProduced['Membership']['club'], 'LR', 0, 'R', $fill);
	$tcpdf->Cell($w[5], $h, $licenceProduced['User']['ffc_id']."/".$licenceProduced['Membership']['l_yearly_number'], 'LR', 0, 'R', $fill);
	$tcpdf->Ln();
	$fill=!$fill;

}
$tcpdf->Cell(array_sum($w), 0, '', 'T');


$tcpdf->Output('Licences_'.date('Y').'_'.date('m').'_'.date('d').'_'.date('H').'_'.date('i').'.pdf','D');

?>