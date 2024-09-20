<?php

namespace App\Http\Controllers\Question;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Question\Question;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Models\MySql\Biodeposit\User_questions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    public function __construct(
        private Question $model
    )
    {
        parent::__construct();
    }
    public function getQuestions(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getQuestions()
        );
    }
    public function deleteQuestions(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . User_questions::class . ',id'],
        ]);
        $this->model->deleteQuestions($validated);
        return $this->makeGoodResponse([]);
    }
    public function sendAnswer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . User_questions::class . ',id'],
            'answer' => ['required', 'string', 'max:500'],
        ]);
        try {
            $this->model->sendAnswer($validated);
            return $this->makeGoodResponse([]);
        }catch (BaseException $exception){
            return $this->makeBadResponse($exception);
        }
    }
}
