<?php
	session_start();

	require('fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(190,10,'Intervention',0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',12);
    
    $affichePDF = $_SESSION['affichePDF'];

    $afficheTechnicien = $_SESSION['afficheTechnicien'];

    $afficheClient= $_SESSION['afficheClient'];

    $pdf->Cell(40,10, utf8_decode('N°Intervention : ')." ".$affichePDF['numero_intervention']);
    $pdf->Ln();
    $pdf->Cell(40,10, 'Date visite : '." ".$affichePDF['date_visite']);
    $pdf->Ln();
    $pdf->Cell(40,10, 'Heure visite : '." ".$affichePDF['heure_visite']);
    $pdf->Ln();
    $pdf->Cell(40,10, utf8_decode('N°Client: ')." ".$affichePDF['numero_client']);
    $pdf->Ln();
    $pdf->Cell(40,10, 'Client : '." ".utf8_decode($afficheClient['nomC'])." ".utf8_decode($afficheClient['prenomC']));
    $pdf->Ln();
    $pdf->Cell(40,10, 'Technicien : '." ".utf8_decode($afficheTechnicien['nom'])." ".utf8_decode($afficheTechnicien['prenom']));

    $pdf->Output();
?>
