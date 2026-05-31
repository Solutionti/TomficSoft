<?php

require_once __DIR__ . '/fpdf.php';

class FPDF_Doc extends FPDF {
    function Header() {}
    function Footer() {
        $this->SetY(-12);
        $this->SetFont('Arial','I',7);
        $this->SetTextColor(150,150,150);
        $this->Cell(0,5,'TomficSoft — Documentacion Funcional del Sistema   |   Pag. '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function SeccionTitulo($texto) {
        $this->SetFillColor(45,102,34);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,9,' '.$texto,0,1,'L',true);
        $this->SetTextColor(13,36,9);
        $this->Ln(2);
    }
    function ModuloTitulo($num, $titulo) {
        $this->SetFillColor(240,247,236);
        $this->SetTextColor(45,102,34);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,$num.'. '.$titulo,0,1,'L',true);
        $this->SetTextColor(13,36,9);
    }
    function SubTitulo($texto) {
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(74,138,55);
        $this->Cell(0,6,$texto,0,1,'L');
        $this->SetTextColor(13,36,9);
    }
    function Parrafo($texto) {
        $this->SetFont('Arial','',8);
        $this->SetTextColor(60,60,60);
        $this->MultiCell(0,5,utf8_decode($texto),0,'L');
        $this->Ln(1);
    }
    function Item($texto) {
        $this->SetFont('Arial','',8);
        $this->SetTextColor(60,60,60);
        $this->Cell(6,5,'',0,0);
        $this->Cell(4,5,chr(149),0,0);
        $this->MultiCell(0,5,utf8_decode($texto),0,'L');
    }
    function TablaFila($col1,$col2,$col3=null,$fill=false) {
        $this->SetFillColor(248,252,246);
        $this->SetFont('Arial','',$fill?8:8);
        if($fill) $this->SetFont('Arial','B',8);
        $w = $col3!==null ? [55,65,62] : [70,112];
        $this->Cell($w[0],6,utf8_decode($col1),'LTB',0,'L',$fill);
        $this->Cell($w[1],6,utf8_decode($col2),'TB',0,'L',$fill);
        if($col3!==null) $this->Cell($w[2],6,utf8_decode($col3),'TBR',0,'L',$fill);
        else $this->Cell(0,6,'','TB',0,'L',$fill);
        $this->Ln();
    }
    function Separador() { $this->Ln(4); }
}
