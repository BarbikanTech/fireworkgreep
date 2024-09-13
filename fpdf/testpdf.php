<?php
$servername="localhost";
$username="root";
$password="";
$database="test";

$conn=new mysqli($servername,$username,$password,$database);

if($conn->connect_error)
{
 die("connection fail:".$conn->connect_error);
}

if(isset($_GET['print_id']))
{
  $print_id=$_GET['print_id'];
  
   $sql="SELECT username,useremail,userphoneno,useraddress,userstate,userpincode,usernationality,userqualification,fileimage FROM form where Id='".$print_id."' ";

// $res=($conn,$sql);
    ob_start();
        require_once('fpdf.php');
        $pdf = new FPDF('p','mm','A4');
        $pdf->AddPage();
        $pdf->SetTitle('Registration Form');
        $pdf->SetFont('Arial','B',10);
        $pdf->SetY(7);
        $pdf->SetFillColor(0,0,255);
        $pdf->SetTextColor(253,254,255);
        $pdf->cell(0,6,' Student Details',1,1,'C',1);


        
        


        
        $pdf->SetTextColor(31,51,39);
        
        $pdf->SetFont('Arial','',10);
        $res = $conn->query($sql);
        $row=$res->fetch_assoc();


        //     $i=0;
        //     while($row=$res->fetch_assoc())
        //     {
               $file= base64_decode($row['fileimage']);
               $decodeusernmae = base64_decode($row['username']);
               $decodeemail = base64_decode($row['useremail']);
               $decodeaddress = base64_decode($row['useraddress']);
               $decodephoneno = base64_decode($row['userphoneno']);
               $decodestate = base64_decode($row['userstate']);
               $decodepincode = base64_decode($row['userpincode']);
               $decodenationality = base64_decode($row['usernationality']);
               $decodequalification = base64_decode($row['userqualification']);

               $pdf->image('../upload/'.$file,80,20,50,50);
               $pdf->SetY(80);

               $pdf->Cell(0,8,'',0,1,'C');


               
                $pdf->SetX(70);
                $pdf->Cell(0,6,'Username : ',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodeusernmae,0,1,'L');

                $pdf->Cell(60);
                $pdf->Cell(0,6,'Email: ',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodeemail,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'Address',0,0,'L');
                $pdf->SetX(100);
                $pdf->cell(0,6,$decodeaddress,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'Phone no',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodephoneno,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'State',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodestate,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'Pincode',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodepincode,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'Nationality',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodenationality,0,1,'L');

                $pdf->SetX(70);
                $pdf->Cell(0,6,'Qualification',0,0,'L');
                $pdf->SetX(100);
                $pdf->Cell(0,6,$decodequalification,0,1,'L');

        //     }
    
    }
    else
    {
        echo "Query not selected";
    }

    $pdf->output();


ob_end_flush();

?>