<?php 
  require ("fpdf/fpdf.php");
  require ("word.php");
  require "config.php"; 

  //customer and invoice details
  $info=[
    "customer"=>"",
    "address"=>",",
    "city"=>"",
    "invoice_no"=>"",
    "invoice_date"=>"",
    "total_amt"=>"",
    "words"=>"",
  ];
  
  //Select Invoice Details From Database
  $sql="select * from invoice where SID='{$_GET["id"]}'";
  $res=$con->query($sql);
  if($res->num_rows>0){
	  $row=$res->fetch_assoc();
	  
	  $obj=new IndianCurrency($row["GRAND_TOTAL"]);
	 

	  $info=[
		"customer"=>$row["CNAME"],
		"address"=>$row["CADDRESS"],
		"city"=>$row["PHONE"],
		"invoice_no"=>$row["INVOICE_NO"],
		"invoice_date"=>date("d-m-Y",strtotime($row["INVOICE_DATE"])),
		"total_amt"=>$row["GRAND_TOTAL"],
		"words"=> $obj->get_words(),
	  ];
  }
  
  //invoice Products
  $products_info=[];
  
  //Select Invoice Product Details From Database
  $sql="select * from invoice_products where SID='{$_GET["id"]}'";
  $res=$con->query($sql);
  if($res->num_rows>0){
	  while($row=$res->fetch_assoc()){
		   $products_info[]=[
			"name"=>$row["PNAME"],
			"price"=>$row["PRICE"],
			"qty"=>$row["QTY"],
			"total"=>$row["TOTAL"],
		   ];
	  }
  }
  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',15);
      $this->Cell(20,10,"Ovijat",0,1);
      $this->SetFont('Arial','',10);
      $this->Cell(20,3,"West Street,",0,1);
    
      
      //Display INVOICE text
      $this->SetY(10);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(15,15,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,25,210,25);
    }
    
    function body($info,$products_info){
      
      //Billing Details
      $this->SetY(30);
      $this->SetX(10);
      $this->SetFont('Arial','B',10);
      $this->Cell(50,10,"Bill To: ".$info["customer"],0,1);
      $this->SetFont('Arial','',10);
  
      $this->Cell(50,5,$info["address"]." ".$info["city"],0,1);

      
      //Display Invoice no
      $this->SetY(30);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(37);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(45);
      $this->SetX(10);
      $this->SetFont('Arial','B',10);
      $this->Cell(130,9,"DESCRIPTION",1,0);
      $this->Cell(20,9,"PRICE",1,0,"C");
      $this->Cell(20,9,"Quantity",1,0,"C");
      $this->Cell(20,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','B',10);
      
      //Display table product rows
      $sl=1;
      foreach($products_info as $row){
        $this->Cell(130,9,$sl.". ".$row["name"],"LR",0);
        $this->Cell(20,9,$row["price"],"R",0,"R");
        $this->Cell(20,9,$row["qty"],"R",0,"C");
        $this->Cell(20,9,$row["total"],"R",1,"R");
    
        $sl++;
      
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(130,9,"","LR",0);
        $this->Cell(20,9,"","R",0,"R");
        $this->Cell(20,9,"","R",0,"C");
        $this->Cell(20,9,"","R",1,"R");
        
      }
      //Display table total row
      $this->SetFont('Arial','B',7);
      $this->Cell(130,9,$info["words"],1,0,"C");
      $this->SetFont('Arial','B',10);
      $this->Cell(20,9,"TOTAL",1,0,"R");
      $this->SetFont('Arial','B',12);
      $this->Cell(40,9,$info["total_amt"],1,1,"R");
      
      //Display amount in words
      $this->SetY(265);
      $this->SetX(10);
      $this->SetFont('Arial','B',10);
    
      $this->SetFont('Arial','',12);
     
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-30);
      $this->SetFont('Arial','B',10);
      $this->Cell(0,10,"",0,1,"R");
      $this->Ln(0);
      $this->SetFont('Arial','',8);
      $this->Cell(0,0,"Authorized Signature",0,1,"R");
      $this->Cell(30,0,"Receiver's Signature",0,1,"R");
      $this->SetFont('Arial','',5);
      
      //Display Footer Text
      $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $this->Cell(0,0,"This computer generated invoice is developed by KowshiqueRoy@gmail.com. Visit:  $actual_link",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  $pdf->Output();
?>