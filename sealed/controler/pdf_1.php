<?php

//ob_start();

class PDF extends FPDF {

    public function setImagem($logo, $width, $header_width) {
        
    }

    function Header() {
        
    }

    //Page footer
    function Footer() {
        
    }

    function HeaderTitle($title) {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        //$this->Cell(250);
        // Title
        $this->Cell(30, 10, utf8_decode($title), 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

}

switch ($relatorio) {
    //aqui
    case "formulario" :
        $cont = 1;
        $y = 1;
        foreach ($formularios as $formulario) {
            if ($formulario['destinatario']) {
                $pdf = new PDF("P", "pt", "A4");
                $pdf->AddPage();
                $pdf->Ln();
                $pdf->HeaderTitle('Peça');
                $pdf->Ln();
                $pdf->SetFont('arial', '', 8);
                $pdf->Cell('', 20, utf8_decode('- ' . $formulario['peca']), 0, 1, 'L');
                $pdf->Cell('', 20, utf8_decode('- ' . $formulario['unidade']), 0, 1, 'L');
                $pdf->Cell('', 140, '', 0, 1, 'L');
                $pdf->SetFont('arial', 'B', 15);
                $pdf->Cell('', 20, utf8_decode('Remetente: '), 0, 1, 'L');
                $pdf->SetFont('arial', '', 8);
                $pdf->Cell('', 20, utf8_decode('Edmmundo Martins QNO'), 0, 1, 'L');
                $pdf->Cell('', 350, '', 0, 1, 'L');
                $pdf->SetFont('arial', 'B', 15);
                $pdf->Cell('', 20, utf8_decode('Destinatário: '), 0, 1, 'L');
                $pdf->SetFont('arial', '', 8);
                $pdf->Cell('', 20, utf8_decode($formulario['destinatario']), 0, 1, 'L');
                //ob_clean();
                $pdf->Output('pdf/relatorio('. $cont . ")".date('d-m-Y H_i_s').".pdf", "F");
                $y++;
            }
            $cont++;
        }
        if ($y == 1) {
            $response['error'][] = 'Preencha o formulario corretamente!';
        }
        break;
}
?>