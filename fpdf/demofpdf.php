<?php
 ob_start();

 require_once('fpdf.php');
 $pdf=new FPDF('p','mm','A4');
 $pdf->AddPage();
 $pdf->SetAutoPageBreak(false);
 $pdf->SetTitle("Demo Pdf");
 $pdf->SetFont('Arial','',8);
 $pdf->SetX(10);
 $pdf->Cell(0,6,'Estimate No:2022KCET09',0,0,'L',0);
 $pdf->SetX(10);
 $pdf->Cell(0,6,'Estimate',0,0,'C',0);
 $pdf->SetX(10);
 $pdf->Cell(0,6,'Date:17/12/2022',0,1,'R',0);

 
 $pdf->SetY(17);
 $hstarxaxis = $pdf->GetY();
 $pdf->Cell(0,6,"Mobile:99941 11571",0,0,'L',0);
 $pdf->SetY(17);
 $pdf->Cell(0,6,'Email:sriKannabirancrackers30@gmail.com',0,1,'R',0);
 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(22);
 $pdf->Cell(0,8,'SRI KANNABIRAN CRAKERS',0,1,'C',0);
 $pdf->SetFont('Arial','',8);
 $pdf->SetY(27);
 $pdf->Cell(0,6,'12/27/01 Sri Kannabiran Nagar,Vaani Oil Mill(OPP),Sattur Road,Meenampatti,Sivakasi-626189',0,1,'C',0);
 $hendxaxis = $pdf->GetY();
 $pdf->SetY(17);
 $pdf->Cell(0,$hendxaxis-$hstarxaxis,'',1,1);

 $pdf->SetY(35);
 $pdf->Image('logo.png',10,35,-500);

 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(35);
 $astarxaxis=$pdf->GetY();
 $pdf->Cell(172,8,'Customer Details',0,1,'R',0);
 $pdf->Sety(41);
 $pdf->SetX(178);
 $pdf->Cell(25,8,'VASANTH',0,1,'L',0);
 $pdf->SetFont('Arial','',8);
 $pdf->SetY(45);
 $pdf->SetX(178);
 $pdf->Cell(25,8,'HOSUR',0,1,'L',0);
 $pdf->SetY(49);
 $pdf->SetX(178);
 $pdf->Cell(25,8,'HOSUR',0,1,'L',0);
 $pdf->SetY(53);
 $pdf->SetX(178);
 $pdf->Cell(25,8,'Tamil Nadu',0,1,'L',0);
 $pdf->SetY(57);
 $pdf->SetX(178);
 $pdf->Cell(25,8,'9538601312',0,1,'L',0);
 $aendxaxis=$pdf->GetY();
 $pdf->Sety($hendxaxis);
 $pdf->Cell(0,$aendxaxis-$astarxaxis,'',1,1);

 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(63);
 $pdf->SetX(10);
 $pdf->Cell(10,10,'Sl.No',1,0,'C');
 $pdf->SetX(20);
 $pdf->Cell(20,10,'Code',1,0,'C');
 $pdf->SetX(40);
 $pdf->Cell(50,10,'Product',1,0,'C');
 $pdf->SetX(90);
 $pdf->cell(30,10,'Content',1,0,'C');
 $pdf->SetX(120);
 $pdf->Cell(30,10,'Quantity',1,0,'C');
 $pdf->SetX(150);
 $pdf->Cell(30,10,'Rate',1,0,'C');
 $pdf->SetX(180);
 $pdf->Cell(20,10,'Amount',1,1,'C');

 $nstartxaxis = $pdf->GetY();
 $pdf->SetY(75);
 $pdf->cell(0,5,'Net Rate Products',0,1,'L',0);
 $nendxaxis = $pdf->GetY();
 $pdf->SetY(73);
 $pdf->Cell(0,$nendxaxis-$nstartxaxis,'',1,1);


 $pdf->SetFont('Arial','',8);
 $pdf->SetY(80);

 $pdf->SetX(10);
 $pdf->Cell(10,8,'1',1,0,'C',0);
 $pdf->SetX(20);
 $pdf->Cell(20,8,'129',1,0,'C');
 $pdf->SetX(40);
 $pdf->Cell(50,8,'32 Item Gift Box',1,0,'C',0);
 $pdf->SetX(90);
 $pdf->Cell(30,8,'Box',1,0,'C',0);
 $pdf->SetX(120);
 $pdf->Cell(30,8,'1',1,0,'C',0);
 $pdf->SetX(150);
 $pdf->Cell(30,8,'630.00',1,0,'C',0);
 $pdf->SetX(180);
 $pdf->Cell(20,8,'630.00',1,0,'C',0);

 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(88);
 $pdf->SetX(180);
 $pdf->Cell(20,8,'630.00',1,0,'C',0);
 $pdf->SetX(10);
 $pdf->Cell(170,8,'Total',1,0,'R',0);

 $pdf->SetY(96);
 $pdf->Cell(0,8,'Discount Products',1,1,'L');

 $pdf->SetFont('Arial','',8);

  $pdf->SetY(104);

 for($i=2;$i<35;$i++)
 {
    $pdf->SetX(10);
    $pdf->Cell(10,8,$i,1,0,'C');
    $pdf->SetX(20);
    $pdf->Cell(20,8,$i,1,0,'C');
    $pdf->SetX(40);
    $pdf->Cell(50,8,'10 Cm Eletctic Sparkelers',1,0,'C');
    $pdf->SetX(90);
    $pdf->Cell(30,8,'Box',1,0,'C');
    $pdf->SetX(120);
    $pdf->Cell(30,8,'1',1,0,'C');
    $pdf->SetX(150);
    $pdf->Cell(30,8,'68.00',1,0,'C');
    $pdf->SetX(180);
    $pdf->Cell(20,8,'68.00',1,1,'C');

    $lenght=$pdf->GetY();

    if($lenght >= 260)
    {
        $pdf->AddPage();

        $pdf->SetX(10);
        $pdf->Cell(0,6,'Estimate No:2022KCET09',0,0,'L',0);
        $pdf->SetX(10);
        $pdf->Cell(0,6,'Estimate',0,0,'C',0);
        $pdf->SetX(10);
        $pdf->Cell(0,6,'Date:17/12/2022',0,1,'R',0);

        
        $pdf->SetY(17);
        $hstarxaxis = $pdf->GetY();
        $pdf->Cell(0,6,"Mobile:99941 11571",0,0,'L',0);
        $pdf->SetY(17);
        $pdf->Cell(0,6,'Email:sriKannabirancrackers30@gmail.com',0,1,'R',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetY(22);
        $pdf->Cell(0,8,'SRI KANNABIRAN CRAKERS',0,1,'C',0);
        $pdf->SetFont('Arial','',8);
        $pdf->SetY(27);
        $pdf->Cell(0,6,'12/27/01 Sri Kannabiran Nagar,Vaani Oil Mill(OPP),Sattur Road,Meenampatti,Sivakasi-626189',0,1,'C',0);
        $hendxaxis = $pdf->GetY();
        $pdf->SetY(17);
        $pdf->Cell(0,$hendxaxis-$hstarxaxis,'',1,1);

        $pdf->SetFont('Arial','B',8);
        
        $pdf->SetX(10);
        $pdf->Cell(10,10,'Sl.No',1,0,'C');
        $pdf->SetX(20);
        $pdf->Cell(20,10,'Code',1,0,'C');
        $pdf->SetX(40);
        $pdf->Cell(50,10,'Product',1,0,'C');
        $pdf->SetX(90);
        $pdf->cell(30,10,'Content',1,0,'C');
        $pdf->SetX(120);
        $pdf->Cell(30,10,'Quantity',1,0,'C');
        $pdf->SetX(150);
        $pdf->Cell(30,10,'Rate',1,0,'C');
        $pdf->SetX(180);
        $pdf->Cell(20,10,'Amount',1,1,'C');
        $pdf->SetFont('Arial','',8);
         
    }
 }
 
 $len=$pdf->GetY();
 $pdf->SetY($len);
 $pdf->SetX(10);
 $pdf->Cell(170,8,'Sub Total',1,0,'R');
 $pdf->SetX(180);
 $pdf->Cell(20,8,'14,002.00',1,1,'R');
 $pdf->Cell(170,8,'Discount (70%)',1,0,'R');
 $pdf->Cell(20,8,'9,301',1,1,'C');
 $pdf->Cell(170,8,'Total',1,0,'R');
 $pdf->Cell(20,8,'4,200',1,1,'R');

 $len=$pdf->GetY();


    $pdf->SetX(10);
    $pdf->Cell(10,220-$len,'',1,0,'C');
    $pdf->SetX(20);
    $pdf->Cell(20,220-$len,'',1,0,'C');
    $pdf->SetX(40);
    $pdf->Cell(50,220-$len,'',1,0,'C');
    $pdf->SetX(90);
    $pdf->Cell(30,220-$len,'',1,0,'C');
    $pdf->SetX(120);
    $pdf->Cell(30,220-$len,'',1,0,'C');
    $pdf->SetX(150);
    $pdf->Cell(30,220-$len,'',1,0,'C');
    $pdf->SetX(180);
    $pdf->Cell(20,220-$len,'',1,1,'C');

 $pdf->SetY(220);
 $pdf->SetX(10);
 $pdf->Cell(170,8,'NetTotal',1,0,'R');
 $pdf->Cell(20,8,'4,830.00',1,1,'R');
 $pdf->Cell(170,8,'Cash Back (10%)',1,0,'R');
 $pdf->Cell(20,8,'7,530.00',1,1,'R');
 $pdf->Cell(170,8,'Payable Amount',1,0,'R');
 $pdf->Cell(20,8,'17,633',1,1,'R');
 $pdf->Cell(170,8,'Round Of',1,0,'R');
 $pdf->Cell(20,8,'7,821.00',1,1,'R');

 $pdf->SetX(10);
 $pdf->cell(110,10,'Total',1,0,'R');
 $pdf->SetX(120);
 $pdf->Cell(30,10,'65',1,0,'R');
 $pdf->SetX(150);
 $pdf->Cell(30,10,'Total',1,0,'R');
 $pdf->SetX(180);
 $pdf->Cell(20,10,'4,321.00',1,1,'C');
 $pdf->SetX(10);
 $pdf->Cell(30,8,'Amount(in words)',1,0,'L');
 $pdf->Cell(160,8,'Four Thousand Three Hundred Twenty one Rupees',1,1,'L');

 $lstartxaxis = $pdf->GetY();
 $pdf->Cell(0,6,'Declaration',0,1,'L');
 $pdf->Cell(0,6,'We declare that this bill shows the acual price of the goods',0,1,'L');
 $pdf->Cell(0,6,'described and that all particulars are true and correct',0,1,'L');
 $lendxaxis = $pdf->GetY();
 $pdf->Cell(0,$lstartxaxis-$lendxaxis,'',1,0);



 $pdf->output();

 ob_end_flush();
?>