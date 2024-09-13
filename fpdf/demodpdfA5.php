<?php
 ob_start();

 require_once('fpdf.php');
 $pdf=new FPDF('p','mm','A5');
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

 $pdf->Image('logo.png',10,35,-500);
 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(35);
 $astarxaxis=$pdf->GetY();
 $pdf->Cell(110,8,'Customer Details',0,1,'R',0);
 $pdf->Sety(41);
 $pdf->SetX(120);
 $pdf->Cell(0,8,'VASANTH',0,1,'L',0);
 $pdf->SetFont('Arial','',8);
 $pdf->SetY(45);
 $pdf->SetX(120);
 $pdf->Cell(0,8,'HOSUR',0,1,'L',0);
 $pdf->SetY(49);
 $pdf->SetX(120);
 $pdf->Cell(0,8,'HOSUR',0,1,'L',0);
 $pdf->SetY(53);
 $pdf->SetX(120);
 $pdf->Cell(0,8,'Tamil Nadu',0,1,'L',0);
 $pdf->SetY(57);
 $pdf->SetX(120);
 $pdf->Cell(0,8,'9538601312',0,1,'L',0);
 $aendxaxis=$pdf->GetY();
 $pdf->Sety($hendxaxis);
 $pdf->Cell(0,$aendxaxis-$astarxaxis,'',1,1);

 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(63);
 $pdf->SetX(10);
 $pdf->Cell(10,10,'Sl.No',1,0,'C');
 $pdf->SetX(20);
 $pdf->Cell(15,10,'Code',1,0,'C');
 $pdf->SetX(35);
 $pdf->Cell(40,10,'Product',1,0,'C');
 $pdf->SetX(75);
 $pdf->cell(15,10,'Content',1,0,'C');
 $pdf->SetX(90);
 $pdf->Cell(15,10,'Quantity',1,0,'C');
 $pdf->SetX(105);
 $pdf->Cell(15,10,'Rate',1,0,'C');
 $pdf->SetX(120);
 $pdf->Cell(18.5,10,'Amount',1,1,'C');

 $nstartxaxis = $pdf->GetY();
 $pdf->SetY(75);
 $pdf->cell(0,5,'Net Rate Products',0,1,'L',0);
 $nendxaxis = $pdf->GetY();
 $pdf->SetY(73);
 $pdf->Cell(0,$nendxaxis-$nstartxaxis,'',1,1);


 $pdf->SetFont('Arial','',8);
 $pdf->SetY(80);

 $pdf->SetFont('Arial','',8);

 $pdf->SetX(10);
 $pdf->Cell(10,8,'1',1,0,'C');
 $pdf->SetX(20);
 $pdf->Cell(15,8,'129',1,0,'C');
 $pdf->SetX(35);
 $pdf->Cell(40,8,'32 Item Gift Box',1,0,'C');
 $pdf->SetX(75);
 $pdf->cell(15,8,'Box',1,0,'C');
 $pdf->SetX(90);
 $pdf->Cell(15,8,'1',1,0,'C');
 $pdf->SetX(105);
 $pdf->Cell(15,8,'630.00',1,0,'C');
 $pdf->SetX(120);
 $pdf->Cell(18.5,8,'630.00',1,1,'C');

 $pdf->SetFont('Arial','B',8);
 $pdf->SetY(88);
 $pdf->SetX(180);
 $pdf->Cell(20,8,'630.00',1,0,'C',0);
 $pdf->SetX(10);
 $pdf->Cell(128.5,8,'Total',1,0,'R',0);

 $pdf->SetY(96);
 $pdf->Cell(0,8,'Discount Products',1,1,'L');

 $pdf->SetFont('Arial','',8);

  $pdf->SetY(104);

 for($i=2;$i<15;$i++)
 {
    $pdf->SetFont('Arial','',8);
    
    $pdf->SetX(10);
    $pdf->Cell(10,10,$i,1,0,'C');
    $pdf->SetX(20);
    $pdf->Cell(15,10,$i,1,0,'C');
    $pdf->SetX(35);
    $pdf->Cell(40,10,'10 Cm Eletctic Sparkelers',1,0,'C');
    $pdf->SetX(75);
    $pdf->cell(15,10,'Box',1,0,'C');
    $pdf->SetX(90);
    $pdf->Cell(15,10,'1',1,0,'C');
    $pdf->SetX(105);
    $pdf->Cell(15,10,'680.00',1,0,'C');
    $pdf->SetX(120);
    $pdf->Cell(18.5,10,'680.00',1,1,'C');

    $lenght=$pdf->GetY();

    if($lenght >= 200)
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

        $pdf->SetFont('Arial','B',8);
      
        $pdf->SetX(10);
        $pdf->Cell(10,10,'Sl.No',1,0,'C');
        $pdf->SetX(20);
        $pdf->Cell(15,10,'Code',1,0,'C');
        $pdf->SetX(35);
        $pdf->Cell(40,10,'Product',1,0,'C');
        $pdf->SetX(75);
        $pdf->cell(15,10,'Content',1,0,'C');
        $pdf->SetX(90);
        $pdf->Cell(15,10,'Quantity',1,0,'C');
        $pdf->SetX(105);
        $pdf->Cell(15,10,'Rate',1,0,'C');
        $pdf->SetX(120);
        $pdf->Cell(18.5,10,'Amount',1,1,'C');
                
         
    }
 }
 
 $len=$pdf->GetY();
 $pdf->SetY($len);
 $pdf->SetX(10);
 $pdf->Cell(110,8,'Sub Total',1,0,'R');
 $pdf->SetX(120);
 $pdf->Cell(18.5,8,'14,002.00',1,1,'R');
 $pdf->Cell(110,8,'Discount (70%)',1,0,'R');
 $pdf->Cell(18.5,8,'9,301',1,1,'C');
 $pdf->Cell(110,8,'Total',1,0,'R');
 $pdf->Cell(18.5,8,'4,200',1,1,'R');

 $len=$pdf->GetY();


    $pdf->SetX(10);
    $pdf->Cell(10,140-$len,'',1,0,'C');
    $pdf->SetX(20);
    $pdf->Cell(15,140-$len,'',1,0,'C');
    $pdf->SetX(35);
    $pdf->Cell(40,140-$len,'',1,0,'C');
    $pdf->SetX(75);
    $pdf->Cell(15,140-$len,'',1,0,'C');
    $pdf->SetX(90);
    $pdf->Cell(15,140-$len,'',1,0,'C');
    $pdf->SetX(105);
    $pdf->Cell(15,140-$len,'',1,0,'C');
    $pdf->SetX(120);
    $pdf->Cell(18.5,140-$len,'',1,1,'C');


    

 $pdf->SetY(140);
 $pdf->SetX(10);
 $pdf->Cell(110,8,'NetTotal',1,0,'R');
 $pdf->Cell(18.5,8,'4,830.00',1,1,'R');
 $pdf->Cell(110,8,'Cash Back (10%)',1,0,'R');
 $pdf->Cell(18.5,8,'7,530.00',1,1,'R');
 $pdf->Cell(110,8,'Payable Amount',1,0,'R');
 $pdf->Cell(18.5,8,'17,633',1,1,'R');
 $pdf->Cell(110,8,'Round Of',1,0,'R');
 $pdf->Cell(18.5,8,'7,821.00',1,1,'R');

 $pdf->SetX(10);
 $pdf->cell(110,10,'Total',1,0,'R');
 $pdf->SetX(120);
 $pdf->Cell(18.5,10,'65',1,0,'R');
 $pdf->SetX(150);
 $pdf->Cell(30,10,'Total',1,0,'R');
 $pdf->SetX(180);
 $pdf->Cell(18.5,10,'4,321.00',1,1,'C');
 $pdf->SetX(10);
 $pdf->Cell(30,8,'Amount(in words)',1,0,'L');
 $pdf->Cell(98.5,8,'Four Thousand Three Hundred Twenty one Rupees',1,1,'L');

 $lstartxaxis = $pdf->GetY();
 $pdf->Cell(0,6,'Declaration',0,1,'L');
 $pdf->Cell(0,6,'We declare that this bill shows the acual price of the goods',0,1,'L');
 $pdf->Cell(0,6,'described and that all particulars are true and correct',0,1,'L');
 $lendxaxis = $pdf->GetY();
 $pdf->Cell(0,$lstartxaxis-$lendxaxis,'',1,0);



 $pdf->output();

 ob_end_flush();
?>