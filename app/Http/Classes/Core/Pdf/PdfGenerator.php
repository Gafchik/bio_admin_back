<?php

namespace App\Http\Classes\Core\Pdf;

use Dompdf\{Dompdf,Options};

class PdfGenerator implements PdfGeneratorInterface
{
    public function getPdf(
        string $pathTemplate,               //путь к верстке
        array $templateData = [],           //данные в верстку
        string $format = 'A4',              //формат
        string $orientation = 'portrait'    //ориентация
    ): Dompdf
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $pdf = new Dompdf($options);
        $pdf->loadHtml(mb_convert_encoding(view($pathTemplate, $templateData)->render(), 'HTML-ENTITIES', 'UTF-8'));
        $pdf->setPaper($format, $orientation);
        $pdf->render();
        return $pdf;
    }
}
