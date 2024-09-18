<?php

namespace App\Http\Classes\Core\Pdf;

use Dompdf\Dompdf;

interface PdfGeneratorInterface
{
    public function getPdf(string $pathTemplate, array $templateData = [], string $format = 'A4', string $orientation = 'portrait'): Dompdf;
}
