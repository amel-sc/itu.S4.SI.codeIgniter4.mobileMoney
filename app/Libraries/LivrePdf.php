<?php

namespace App\Libraries;

require_once APPPATH . 'ThirdParty/FPDF/fpdf.php';

class LivrePdf extends \FPDF
{
    // function to decode string
    private function decode($str) {
        return utf8_decode($str);
    }

    // En-tête
    function Header() {
        // sub title
        $this->SetFont('Times','B',17);
        $this->SetTextColor(64,113,140);
        $this->Ln(12);
        $this->Cell(0,0,$this->decode('CATALOGUE DE LIVRES'),0,1,'C');
        $this->Ln(7);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    //  Table de livre
    function livre($livres) {
        $w = array(80, 70, 50, 25, 55);

        $this->SetLeftMargin(10);
        
        $this->Ln(7);
        // En-tête
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($w[0], 7, $this->decode('Titre'), 1, 0, 'L');
        $this->Cell($w[1], 7, $this->decode('Auteur'), 1, 0, 'L');
        $this->Cell($w[2], 7, $this->decode('ISBN'), 1, 0, 'L');
        $this->Cell($w[3], 7, $this->decode('Année'), 1, 0, 'L');
        $this->Cell($w[4], 7, $this->decode('Catégorie'), 1, 0, 'L');

        $this->Ln(7);
        // Données
        $this->SetFont('Arial', '', 12);
        foreach ($livres as $livre) {
            $this->Cell($w[0],7,$this->decode($livre['titre']),1, 0, 'L');
            $this->Cell($w[1],7,$this->decode($livre['auteur']),1, 0, 'L');
            $this->Cell($w[2],7,$this->decode($livre['ISBN']),1, 0, 'L');
            $this->Cell($w[3],7,$this->decode($livre['anneePublication']),1, 0, 'L');
            $this->Cell($w[4],7,$this->decode($livre['categorie']),1, 0, 'L');
            $this->Ln();
        }
    }

    //  function to generate the pdf
    public function generate($livres) {      
        $this->AliasNbPages();  
        $this->AddPage('P', 'A3');
        //  livre
        $this->livre($livres);
        return $this->Output('S');
    }
}