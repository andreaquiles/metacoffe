<?php

//ob_start();

class PDF extends FPDF {

    var $widthItemFornecedoresVenc = 440;
    var $widthItemVencedores = 580;

    public function setImagem($logo, $width, $header_width) {
        
    }

    function Header() {
        
    }

    //Page footer
    function Footer() {
        $this->SetY(-25);
        $start_x = $this->GetX();
        $start_y = $this->GetY();
        $this->AliasNbPages('{totalPages}');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 15, utf8_decode('Relatório emitido pelo site *****'), 0, 0, 'C');
        $this->Cell(60, 15, utf8_decode("Páginas ") . $this->PageNo() . "/{totalPages}", 0, 0, 'R');
    }

    function HeaderLblsCotacaoEncerrada($cotacao, $fornecedor) {
        $this->SetFont('arial', 'B', 11);
        $this->SetFillColor(192, 192, 192);
        $this->Cell('', 20, utf8_decode('Vencedores: ' . ucwords($cotacao)
                        . ' - Fornecedor: ' . ucwords($fornecedor)), 1, 0, 'L', 1);
        $this->Ln();
        $this->Cell(35, 20, ('#'), 1, 0, 'L', 1);
        $this->Cell($this->widthItemVencedores, 20, ('Item'), 1, 0, 'L', 1);
        $this->Cell(80, 20, ('Quantidade'), 1, 0, 'L', 1);
        //$this->Cell(204, 20, ('Fornecedor'), 1, 0, 'L', 1);
        $this->Cell(90, 20, utf8_decode('Total R$'), 1, 0, 'L', 1);
    }

    
    function HeaderLblsProdutosSemPreco($cotacao) {
        $this->SetFont('arial', 'B', 11);
        $this->SetFillColor(192, 192, 192);
        $this->Cell("", 20, utf8_decode($cotacao), 1, 0, 'L', 1);
        $this->Ln();
        $this->Cell(35, 20, ('#'), 1, 0, 'L', 1);
        $this->Cell("", 20, ('Item'), 1, 0, 'L', 1);
    }

}

switch ($relatorio) {
    //aqui
    case "contrato" :
        $pdf = new PDF("L", "pt", "A4");
        $pdf->AddPage();
        $pdf->Ln();
        $cont = 1;
        $y = 1;
        //$pdf->HeaderLblsCotacaoEncerrada('cotacao', 'nome');
        $pdf->Ln();
        $pdf->SetFont('arial', '', 8);
//        $pdf->Cell(35, 20, ($y), 1, 0, 'L');
//        $pdf->Cell(10, 20, utf8_decode('xxx'), 1, 0, 'L');
//        $pdf->Cell(80, 20, 10, 1, 0, 'L');
//        $pdf->Cell(90, 20, 'FUNCOES', 1, 1, 'L');
//        $cont++;
//        $pdf->SetFont('arial', '', 11);
        $pdf->Cell("", 20, "Soma total: R$ " , 1, 0, 'R', 1);
        //ob_clean();
        $pdf->Output('_relatorio' . ".pdf", "F");
        break;
}
?>