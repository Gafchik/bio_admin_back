<?php

namespace App\Http\Facades;

use App\Http\Classes\Core\Pdf\PdfGeneratorInterface;
use Dompdf\Dompdf;

use Illuminate\Support\Facades\Facade;

class PdfFacade extends Facade
{
    /**
     * @method static Dompdf getPdf(string $pathTemplate, array $templateData = [], string $format = 'A4', string $orientation = 'portrait');
     * @see PdfGeneratorInterface
     */
    protected static function getFacadeAccessor()
    {
        return 'pdf_facade';
    }
}
