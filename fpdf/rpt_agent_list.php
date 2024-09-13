<?php
    include("../include_user_check_and_files.php");

    $agent_id = "";
    if(isset($_REQUEST['agent_id'])) {
        $agent_id = $_REQUEST['agent_id'];
    }

    $total_records_list = array();
    if(!empty($GLOBALS['bill_company_id'])) {
        $total_records_list = $obj->getTableRecords($GLOBALS['agent_table'], 'bill_company_id', $GLOBALS['bill_company_id']);
    }

    if(!empty($search_text)) {
        $search_text = strtolower($search_text);
        $list = array();
        if(!empty($total_records_list)) {
            foreach($total_records_list as $val) {
                if( (strpos(strtolower($obj->encode_decode('decrypt', $val['name'])), $search_text) !== false) ) {
                    $list[] = $val;
                }
            }
        }
        $total_records_list = $list;
    }

    $show_records_list = array();
    if(!empty($total_records_list)) {
        foreach($total_records_list as $key => $val) {
            $show_records_list[] = $val;
        }
    }

    $company_list = array();
    $company_list = $obj->getTableRecords($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id']);
    $company_name = ""; $company_address = ""; $company_state = ""; $company_mobile = ""; $company_email = "";
    if(!empty($company_list)){
        foreach($company_list as $data){
            if(!empty($data['name'])){
                $company_name = $obj->encode_decode('decrypt',$data['name']);
            }
            if(!empty($data['address'])){
                $company_address = $obj->encode_decode('decrypt',$data['address']);
            }
            if(!empty($data['mobile_number'])){
                $company_mobile = $data['mobile_number'];
            }
            if(!empty($data['email'])){
                $company_email = $obj->encode_decode('decrypt',$data['email']);
            }
            if(!empty($data['state'])){
                $company_state = $obj->encode_decode('decrypt',$data['state']);
            }
        }
    }

    require_once('../fpdf/fpdf.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf->AliasNbPages(); 
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTitle('Agent List');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetY(7);
    if(!empty($company_name)){
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,4,$company_name,0,1,'C',0);
    }
    $pdf->SetFont('Arial','',8);
    if(!empty($company_address)){
        $pdf->Cell(0,4,$company_address,0,1,'C',0);
    }
    if(!empty($company_state)){
        $pdf->Cell(0,4,$company_state,0,1,'C',0);
    }
    if(!empty($company_mobile)){
        $pdf->Cell(0,4,$company_mobile,0,1,'C',0);
    }
    if(!empty($company_email)){
        $pdf->Cell(0,4,$company_email,0,1,'C',0);
    }
    $y=$pdf->GetY();
    $pdf->SetY(7);
    $pdf->Cell(0,$y-7,'',1,1,'L',0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,10,'Agent List',1,1,'C',0);
    $pdf->SetFont('Arial','B',8);

    $pdf->SetX(10);
    $pdf->Cell(10,10,'S.No.',1,0,'C',0);
    $pdf->SetX(20);
    $pdf->Cell(60,10,'Agent',1,0,'C',0);
    $pdf->SetX(80);
    $pdf->Cell(60,10,'Address',1,0,'C',0);
    $pdf->SetX(140);
    $pdf->Cell(30,10,'Mobile',1,0,'C',0);
    $pdf->SetX(170);
    $pdf->Cell(30,10,'Email',1,1,'C',0);
    $pdf->SetFont('Arial','',8);

    $index = 0;
    if(!empty($show_records_list)) {
        $sno=1;
        foreach($show_records_list as $key => $data) {
            if($pdf->GetY()>260){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(0,5,'Continued to Page Number '.$pdf->PageNo()+1,1,1,'R',0);
                $pdf->SetY(-10);
                $pdf->SetFont('Arial','I',7);
                $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetY(7);
                if(!empty($company_name)){
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(0,4,$company_name,0,1,'C',0);
                }
                $pdf->SetFont('Arial','',8);
                if(!empty($company_address)){
                    $pdf->Cell(0,4,$company_address,0,1,'C',0);
                }
                if(!empty($company_state)){
                    $pdf->Cell(0,4,$company_state,0,1,'C',0);
                }
                if(!empty($company_mobile)){
                    $pdf->Cell(0,4,$company_mobile,0,1,'C',0);
                }
                if(!empty($company_email)){
                    $pdf->Cell(0,4,$company_email,0,1,'C',0);
                }
                $y=$pdf->GetY();
                $pdf->SetY(7);
                $pdf->Cell(0,$y-7,'',1,1,'L',0);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(0,10,'Agent List',1,1,'C',0);
                $pdf->SetFont('Arial','B',8);

                $pdf->SetX(10);
                $pdf->Cell(10,10,'S.No.',1,0,'C',0);
                $pdf->SetX(20);
                $pdf->Cell(60,10,'Agent',1,0,'C',0);
                $pdf->SetX(80);
                $pdf->Cell(60,10,'Address',1,0,'C',0);
                $pdf->SetX(140);
                $pdf->Cell(30,10,'Mobile',1,0,'C',0);
                $pdf->SetX(170);
                $pdf->Cell(30,10,'Email',1,1,'C',0);
                $pdf->SetFont('Arial','',8);
            }
            $agent_name = ""; $agent_address = ""; $agent_city = ""; $agent_state = ""; $agent_mobile = ""; $agent_email = "";
            $name_height = 0; $address_height = 0; $mobile_height = 0; $email_height = 0; $final_height = 0;

            if(!empty($data['name'])){
                $agent_name = $obj->encode_decode('decrypt',$data['name']);
            }
            if(!empty($data['address'])){
                $agent_address = $obj->encode_decode('decrypt',$data['address']);
            }
            if(!empty($data['city'])){
                $agent_city = $obj->encode_decode('decrypt',$data['city']);
            }
            if(!empty($data['state'])){
                $agent_state = $obj->encode_decode('decrypt',$data['state']);
            }
            if(!empty($data['mobile_number'])){
                $agent_mobile = $obj->encode_decode('decrypt',$data['mobile_number']);
            }
            if(!empty($data['email'])){
                $agent_email = $obj->encode_decode('decrypt',$data['email']);
            }

            $yaxis = $pdf->GetY();
            $pdf->SetX(10);
            $pdf->Cell(10,5,$sno,0,0,'C',0);
            
            $pdf->SetX(20);
            $pdf->MultiCell(60,5,$agent_name,0,'L',0);
            $name_height = $pdf->GetY();
            $pdf->SetY($yaxis);
            $pdf->SetX(80);
            $pdf->MultiCell(60,5,$agent_address,0,'C',0);
            $address_height = $pdf->GetY();
            $pdf->SetY($yaxis);
            $pdf->SetX(140);
            $pdf->MultiCell(30,5,$agent_mobile,0,'C',0);
            $mobile_height = $pdf->GetY();
            $pdf->SetY($yaxis);
            $pdf->SetX(170);
            $pdf->MultiCell(30,5,$agent_email,0,'C',0);
            $email_height = $pdf->GetY();

            if($name_height>$address_height && $name_height>$mobile_height && $name_height>$email_height){
                $final_height = $name_height-$yaxis;
            }
            else if($address_height>$name_height && $address_height>$mobile_height && $address_height>$email_height){
                $final_height = $address_height-$yaxis;
            }
            else if($mobile_height>$name_height && $mobile_height>$address_height && $mobile_height>$email_height){
                $final_height = $mobile_height-$yaxis;
            }
            else if($email_height>$name_height && $email_height>$address_height && $email_height>$mobile_height){
                $final_height = $email_height-$yaxis;;
            }
            else{
                $final_height = 5;
            }

            $pdf->SetY($yaxis);
            $pdf->SetX(10);
            $pdf->Cell(10,$final_height,'',1,0,'C',0);
            $pdf->SetX(20);
            $pdf->Cell(60,$final_height,'',1,0,'C',0);
            $pdf->SetX(80);
            $pdf->Cell(60,$final_height,'',1,0,'C',0);
            $pdf->SetX(140);
            $pdf->Cell(30,$final_height,'',1,0,'C',0);
            $pdf->SetX(170);
            $pdf->Cell(30,$final_height,'',1,1,'C',0);

            $sno++;
        }

        $pdf->SetFont('Arial','B',8);
    }
    $pdf->SetY(-10);
    $pdf->SetFont('Arial','I',7);
    $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');

    $pdf->Output();
?>