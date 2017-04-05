<?php
include("fpdf.php");
include("times.php");
class PDF extends FPDF
{
    function Header() {
      if(!empty($_FILES["file"])) {
          $uploaddir = "logo/";
          $nm = $_FILES["file"]["name"];
          $random = rand(1,99);
          move_uploaded_file($_FILES["file"]["tmp_name"], $uploaddir.$random.$nm);
          $this->Image($uploaddir.$random.$nm,10,10,20);
          unlink($uploaddir.$random.$nm);
          }
      $this->SetFont('Arial','B',12);
      $this->Ln(1);
      }
      function Footer() {
          $this->SetY(-15);
          $this->SetFont('Arial','I',8);
          $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
      function ChapterTitle($num, $label){
          $this->SetFont('Arial','',12);
          $this->SetFillColor(200,220,255);
          $this->Cell(0,6,"$num $label",0,1,'L',true);
          $this->Ln(0);
      }
      function ChapterTitle2($num, $label){
          $this->SetFont('Arial','',12);
          $this->SetFillColor(249,249,249);
          $this->Cell(0,6,"$num $label",0,1,'L',true);
          $this->Ln(0);
      }
}
?>
