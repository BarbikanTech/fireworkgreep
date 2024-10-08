<?php
require_once('fpdf.php');
$pdf = new FPDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(15, 25, 15);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTitle('User Details');

$pdf->SetFillColor(238, 235, 235);
$pdf->SetY(25);
$pdf->SetX(35);
$pdf->Cell(0, 40, '', 0, 0, '', 1);
$pdf->SetFillColor(215, 210, 210);
$pdf->Circle(35, 45, 20, 'F');
$pdf->Image('dore.png', 18, 24, 30, 38);
$pdf->SetY(35);
$pdf->SetX(68);
$pdf->SetFillColor(238, 235, 235);
$pdf->SetFont('Times', 'b', 24);
$pdf->Cell(0, 10, 'DIVYA FRANCISE', 0, 0, 'l', 1);
$pdf->SetY(47);
$pdf->SetX(68);
$pdf->SetFont('Times', '', 15);
$pdf->Cell(0, 10, 'Experienced Candidate', 0, 1, 'l', 1);

$pdf->SetFillColor(177, 177, 177);
$pdf->SetY(68);
$pdf->Cell(70, 120, '', 0, 0, '', 1);
$pdf->SetX(15);
$pdf->SetY(90);
$pdf->SetFont('Times', 'BIU', 15);
$pdf->Cell(70, 10, 'User Login Information', 0, 1, 'C', 1);
$pdf->SetFont('Times', 'b', 12, );
$pdf->SetY(100);
$pdf->SetX(20);
$pdf->Cell(70, 10, 'Email Address:', 0, 1, 'L', 1);
$pdf->SetX(20);
$pdf->SetFont('Times', 'I', 12, );
$pdf->Cell(70, 10, 'divyafrancise@gmail.com', 0, 1, 'L', 1);
$pdf->SetY(130);
$pdf->SetX(20);
$pdf->SetFont('Times', 'b', 12, );
$pdf->Cell(70, 10, 'Password:', 0, 1, 'L', 1);
$pdf->SetX(20);
$pdf->SetFont('Times', '', 12, );
$pdf->Cell(70, 10, 'Divyafrancise@123', 0, 1, 'L', 1);

$pdf->SetFillColor(225, 220, 220);
$pdf->SetY(68);
$pdf->SetX(85);
$pdf->Cell(0, 120, '', 0, 0, '', 1);
$pdf->SetY(72);
$pdf->SetX(90);
$pdf->SetFont('Times', 'b', 12);
$pdf->Cell(0, 10, 'Educational qualification:', 0, 1, 'L', 1);
$pdf->SetX(90);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 10, 'B.Tech Chemical Engg', 0, 1, 'L', 1);
$pdf->SetY(98);
$pdf->SetX(90);
$pdf->SetFont('Times', 'b', 12);
$pdf->Cell(0, 10, 'Email address:', 0, 1, 'L', 1);
$pdf->SetX(90);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 10, 'divyafrancise@gmail.com', 0, 1, 'L', 1);
$pdf->SetY(124);
$pdf->SetX(90);
$pdf->SetFont('Times', 'b', 12);
$pdf->Cell(0, 10, 'Mobile Number:', 0, 1, 'L', 1);
$pdf->SetX(90);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 10, '+91-9786027863', 0, 1, 'L', 1);
$pdf->SetY(150);
$pdf->SetX(90);
$pdf->SetFont('Times', 'b', 12);
$pdf->Cell(0, 10, 'Resume:', 0, 1, 'L', 1);
$pdf->SetX(90);
$pdf->SetFont('Times', 'BU', 12);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(0, 10, 'Francise_Divya', 0, 1, 'L', 1, 'http://localhost/demo/Registration/uploads/Francise_Divya.pdf');

$pdf->SetY(190);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(0, 45, '', 0, 0, '', 1);
$pdf->SetY(195);
$pdf->SetX(20);
$pdf->SetFont('Times', 'b', 14);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 10, 'I hereby declare that the above furnished information are true to my knowledge.', 0, 1, 'L', 1);
$pdf->Image('Priyanga sign.jpg', 135, 209, 45, 15);
$pdf->SetY(223);
$pdf->SetX(147);
$pdf->Cell(0, 10, '20/01/2024', 0, 1, '', 1);

$pdf->Line(15, 238, 195, 238);

$pdf->SetY(239);
$pdf->SetFillColor(238, 235, 235);
$pdf->Cell(0, 30, '', 0, 0, '', 1);
$pdf->SetFont('Times', 'BIU', 11);
$pdf->SetY(239);
$pdf->SetX(20);
$pdf->Cell(0, 10, 'Record Purpose:', 0, 1, 'L', 1);
$pdf->SetFont('Times', 'b', 10);
$pdf->SetX(20);
$pdf->Cell(0, 10, 'Candidate Name: Divya Francise', 0, 0, 'L', 1);
$pdf->SetX(130);
$pdf->Cell(0, 10, 'Email Id: divyafrancise@gmail.com', 0, 1, '', 1);
$pdf->SetX(20);
$pdf->Cell(0, 10, 'Unique Id: 27', 0, 0, 'L', 1);
$pdf->SetX(130);
$pdf->Cell(0, 10, 'Mobile No:+91-9786027863', 0, 0, '', 1);
$pdf->output();
?>