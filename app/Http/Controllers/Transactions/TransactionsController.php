<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Classes\LogicalModels\Transactions\Transactions;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Facades\ArchiveFacade;
use App\Http\Facades\PdfFacade;
use App\Models\MySql\Biodeposit\Details_transactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsController extends BaseController
{
    private const DOCUMENTS_PATH = [
        'act' => 'pdfView.document_templates.act',
        'agency_contract' => 'pdfView.document_templates.agency_contract',
        'offer' => 'pdfView.document_templates.offer',
//      'terms_of_use' => 'pdfView.document_templates.terms_of_use', не готово
    ];
    public function __construct(
        private Transactions $model,
    )
    {
        parent::__construct();
    }
    public function getTypes(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getTypes()
        );
    }
    public function getStatuses(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getStatuses()
        );
    }
    public function getTransaction(Request $request): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getTransaction($request->toArray())
        );
    }
    public function getTransactionDetails(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . Details_transactions::class . ',transaction_id',],
        ]);

        return $this->makeGoodResponse(
            $this->model->getTransactionDetails($validated['id'])
        );
    }
    public function download(Request $request)
    {
        $input = ['id'=> $request->id];
        $docData = $this->model->getDocumentData($input);
        $zipData = [];
        foreach (self::DOCUMENTS_PATH as $name => $path){
            $pdf = PdfFacade::getPdf(
                pathTemplate: $path,
                templateData: $docData,
                format: '',
                orientation: '',
            );
            $zipData[$name] = [
                'outputFunction' => 'output',
                'mime' => '.pdf',
                'class' => $pdf,
            ];
        }

        $zipContent = ArchiveFacade::createZipArchive($zipData);

        return response()->stream(
            function () use ($zipContent) {
                echo $zipContent;
            },
            200,
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="Documents_' . $input['id'] . '.zip"',
            ]
        );
    }
}
