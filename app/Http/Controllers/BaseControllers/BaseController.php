<?php

namespace App\Http\Controllers\BaseControllers;

use App\Exceptions\BaseExceptions\BaseException;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Classes\Structure\{HttpStatus, Lang, CustomHeaders};
use App\Http\Controllers\Controller;
use App\Http\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    private Application $app;
    private string $lang = Lang::ENG;
    public function __construct()
    {
        $this->app = app();
        $this->workWithLang();
    }

    protected function makeGoodResponse(array $data): JsonResponse
    {
        return ResponseFacade::makeGoodResponse($data);
    }

    protected function makeBadResponse(BaseException $e): JsonResponse
    {
        return ResponseFacade::makeBadResponse($e);
    }
    private function workWithLang(): void
    {
        $headerLang = request()->header(CustomHeaders::LANG_HEADER);
        if(!is_null($headerLang)){
            $headerLang =  mb_strtolower($headerLang);
            if(in_array($headerLang,Lang::ARRAY_LANG)) {
                $this->lang = $headerLang;
            }
        }
        $this->app->setLocale($this->lang);
    }
}
