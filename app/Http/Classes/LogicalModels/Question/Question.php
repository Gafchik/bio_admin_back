<?php

namespace App\Http\Classes\LogicalModels\Question;

use App\Http\Classes\LogicalModels\Question\Exceptions\QuestionNotFoundException;
use App\Http\Classes\MailModels\Question\AnswerQuestionMailModel;
use App\Http\Classes\MailModels\Withdrawals\WithdrawalsMailModel;
use App\Http\Classes\Structure\CDateTime;
use Illuminate\Support\Facades\Mail;

class Question
{
    public function __construct(
        private QuestionModel $model
    ){}

    public function getQuestions(): array
    {
        return $this->model->getQuestions();
    }
    public function deleteQuestions(array $data): void
    {
        $this->model->deleteQuestions($data);
    }
    public function sendAnswer(array $data): void
    {
        $currentQuestion = $this->model->getCurrentQuestion($data);
        if(is_null($currentQuestion)){
            throw new QuestionNotFoundException();
        }
        Mail::to($currentQuestion['email'])
            ->send(new AnswerQuestionMailModel([
                'question' => $currentQuestion['question'],
                'answer' => $data['answer'],
            ]));

        $this->model->updateQuestion(
            $data['id'],
            [
                'answer' => $data['answer'],
                'updated_at' => CDateTime::getCurrentDate(),
                'answered_at' => CDateTime::getCurrentDate(),
            ]
        );
    }
}
