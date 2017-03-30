<?php

//ob_start ();

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

    function HeaderLblsFornecedoresVenc($cotacao) {
        $this->SetFont('arial', 'B', 11);
        $this->SetFillColor(192, 192, 192);
        $this->Cell(809, 20, utf8_decode('Vencedores: ' . ucwords($cotacao)), 1, 0, 'L', 1);
        $this->Ln();
        $this->Cell(35, 20, ('#'), 1, 0, 'L', 1);
        $this->Cell($this->widthItemFornecedoresVenc, 20, ('Item'), 1, 0, 'L', 1);
        $this->Cell(70, 20, ('Quantidade'), 1, 0, 'L', 1);
        $this->Cell(180, 20, ('Empresa'), 1, 0, 'L', 1);
        $this->Cell(84, 20, utf8_decode('Total R$'), 1, 0, 'L', 1);
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
    case "vencedores" :
        $pdf = new PDF("L", "pt", "A4");
        $pdf->AddPage();
        $pdf->Ln();
        $cont = 1;
        $y = 1;
        $fornecedor_atual = "";
        $somaTotal = 0;
        foreach ($dadosExportarPDF as $dado) {

            if ($fornecedor_atual == "" || $fornecedor_atual == $dado['nome']) {
                if ($cont == 1) {
                    $pdf->HeaderLblsCotacaoEncerrada($dado['cotacao'], ($dado['nome']));
                    $pdf->Ln();
                }
                $pdf->SetFont('arial', '', 8);
                $pdf->Cell(35, 20, ($y), 1, 0, 'L');
                $pdf->Cell($pdf->widthItemVencedores, 20, utf8_decode($dado['item'] . ' (' . $dado['codigo_barras'] . ')'), 1, 0, 'L');
                $pdf->Cell(80, 20, utf8_decode($dado['quantidade']), 1, 0, 'L');
                $pdf->Cell(90, 20, FUNCOES::formatoDecimalHTML($dado['preco'] * $dado['quantidade']), 1, 1, 'L');
                $fornecedor_atual = $dado['nome'];
                $somaTotal+=($dado['preco'] * $dado['quantidade']);
                $y++;
            } else {
                $pdf->SetFont('arial', '', 11);
                $pdf->Cell("", 20, "Soma total: R$ " . FUNCOES::formatoDecimalHTML($somaTotal), 1, 0, 'R', 1);
                $somaTotal = 0;
                $pdf->AddPage();
                $y = 1;
                $pdf->HeaderLblsCotacaoEncerrada($dado['cotacao'], utf8_decode($dado['nome']));
                $pdf->Ln();
                $pdf->SetFont('arial', '', 8);
                $pdf->Cell(35, 20, ($y), 1, 0, 'L');
                $pdf->Cell($pdf->widthItemVencedores, 20, utf8_decode($dado['item'] . ' (' . $dado['codigo_barras'] . ')'), 1, 0, 'L');
                $pdf->Cell(80, 20, utf8_decode($dado['quantidade']), 1, 0, 'L');
                $pdf->Cell(90, 20, FUNCOES::formatoDecimalHTML($dado['preco'] * $dado['quantidade']), 1, 1, 'L');
                $fornecedor_atual = $dado['nome'];
                $somaTotal+=($dado['preco'] * $dado['quantidade']);
                $y++;
            }
            $cont++;
        }
        $pdf->SetFont('arial', '', 11);
        $pdf->Cell("", 20, "Soma total: R$ " . FUNCOES::formatoDecimalHTML($somaTotal), 1, 0, 'R', 1);
        ob_clean();
        $pdf->Output($relatorio . '_' . count($dadosExportarPDF) . ".pdf", "d");
        break;

    case "produtos_conquistados" :
        $pdf = new PDF("L", "pt", "A4");
        $pdf->AddPage();
        $pdf->Ln();
        $cont = 1;
        $y = 1;
        $fornecedor_atual = "";
        $somaTotal = 0;
        foreach ($ProdutosFornecedores as $dado) {

            if ($cont == 1) {
                $pdf->HeaderLblsFornecedoresVenc($dado['cotacao']);
                $pdf->Ln();
            }
            $pdf->SetFont('arial', '', 8);
            $pdf->Cell(35, 20, ($cont), 1, 0, 'L');
            $pdf->Cell($pdf->widthItemFornecedoresVenc, 20, utf8_decode($dado['item'] . ' (' . $dado['codigo_barras'] . ')'), 1, 0, 'L');
            $pdf->Cell(70, 20, utf8_decode($dado['quantidade']), 1, 0, 'L');
            $pdf->Cell(180, 20, utf8_decode($dado['empresa']), 1, 0, 'L');
            $pdf->Cell(84, 20, FUNCOES::formatoDecimalHTML($dado['preco'] * $dado['quantidade']), 1, 1, 'L');
            $somaTotal+=$dado['preco'] * $dado['quantidade'];
            $cont++;
        }
        $pdf->SetFont('arial', 'B', 11);
        $pdf->Cell(809, 20, "Soma total: R$" . FUNCOES::formatoDecimalHTML($somaTotal), 1, 0, 'R', 1);
        ob_clean();
        $pdf->Output($relatorio . ".pdf", "d");
        break;

    case "produtos_sem_precos" :
        $pdf = new PDF("P", "pt", "A4");
        $pdf->AddPage();
        $pdf->Ln();
        $cont = 1;
        $y = 1;
        $fornecedor_atual = "";
        $pdf->HeaderLblsProdutosSemPreco(ucfirst(urldecode($dataGet['nome'])) . " (Produtos sem Preço)");
        $pdf->Ln();
        foreach ($dadosExportarPDF as $dado) {
            $pdf->SetFont('arial', '', 8);
            $pdf->Cell(35, 20, ($cont), 1, 0, 'L');
            $pdf->Cell("", 20, utf8_decode($dado['item'] . ' (' . $dado['codigo_barras'] . ')'), 1, 1, 'L');
            $cont++;
        }
        ob_clean();
        $pdf->Output($relatorio . ".pdf", "d");
        break;
}
?>