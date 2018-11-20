<?php
  //PDF recibo de pago
  require('lib/fpdf153/fpdf.php');//Cargando  libreria
  $pdf = new FPDF("P","mm",array(28,210)); //Declarando clase FPDF
  $pdf->AddPage(); // Agregando pagina
  $x = 0;
  $y = 30;
  //Contenido    
  $pdf->Image('images/logo.jpeg',0,3,28,25);          
  $pdf->SetXY($x,$y);
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(28,3, 'OXYGEN CROSSFIT' ,0,0,'C',0);
  $y += 3;
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, 'GYM' ,0,0,'C',0);
  $y += 2;
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,2, '--------------------------------' ,0,0,'C',0);
  $y += .5;
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,2, '--------------------------------' ,0,0,'C',0);
  //fecha y 
  $pdf->SetFont('Arial','',5);
  $y += 3;
  $pdf->SetXY($x,$y);
  $pdf->Cell(14,4, date("d/m/Y") ,0,0,'L',0);
  $pdf->SetXY(14,$y);
  $pdf->Cell(14,4, date("h:i:sa") ,0,0,'R',0);
  $y += 2;
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '--------------------------------' ,0,0,'C',0);
 
  $pdf->SetXY($x,$y);
 // $y += 2;
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY($x,$y);
 // $pdf->Cell(28,3, '--------------------------------' ,0,0,'C',0);
  $y += 2;
  $pdf->SetFont('Arial','',5 );  
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, 'Pago Mensualidad' ,0,0,'C',0);
  $y += 2;
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '--------------------------------' ,0,0,'C',0);
  $pdf->SetFont('Arial','',5 );
    $y += 35;
  
  $pdf->SetFont('Arial','',5 );
   $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(28,3, 'ID Pago:'.$id = "0015" ,0,0,'L',0);
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(28,3, 'ID Socio:'.$id = "1247" ,0,0,'L',0);
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(28,3, 'Nombre:'.$socio = "Alberto Lopez Ramos" ,0,0,'L',0);
  
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(28,3, 'Fecha inicial:'.$fecha_inicial = "03/09/2017" ,0,0,'L',0);
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(28,3, 'Fecha Final:'.$fecha_final  = "04/09/2017" ,0,0,'L',0);
  $y += 2;
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '--------------------------------' ,0,0,'C',0);
  $pdf->SetFont('Arial','',5 );  
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(14,3, 'Concepto' ,0,0,'L',0);
  $pdf->SetXY(14,$y);  
  $pdf->Cell(14,3, 'Importe' ,0,0,'R',0);
  $pdf->SetFont('Arial','',7);
  $y += 2;
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '_____________________' ,0,0,'C',0);
  $pdf->SetFont('Arial','',5 );
  $y += 4;
  $pdf->SetXY($x,$y);  
  $pdf->Cell(14,3, 'Mensualidad' ,0,0,'L',0);
  $pdf->SetXY(14,$y);  
  $pdf->Cell(14,3, '$  '.$importe = "300.00" ,0,0,'R',0);
  $y += 2;
  $pdf->SetXY(14,$y); 
  $pdf->Cell(14,3, "----------------------" ,0,0,'R',0);
  $y += 2;
  $pdf->SetXY(14,$y); 
  $pdf->Cell(14,3, 'TOTAL:  $    '.$importe ,0,0,'R',0);
  $y+=67;
  
  $pdf->SetFont('Arial','',7);
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '--------------------------------' ,0,0,'C',0);
  $y += 2;
  $pdf->SetXY($x,$y);
  $pdf->SetFont('Arial','',5);                                   
  $pdf->Cell(28,3, 'http://www.oxygencrossfit.com' ,0,0,'C',0);
  $y += 2;
  $pdf->SetXY($x,$y);
  $pdf->Cell(28,3, '(867) 126-7360' ,0,0,'C',0);
  
  
  $pdf->Output();
     
?>
