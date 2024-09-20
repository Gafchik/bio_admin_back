<?php

namespace App\Http\Classes\LogicalModels\Question;

use App\Models\MySql\Biodeposit\User_questions;

class QuestionModel
{
    public function __construct(
        private User_questions $userQuestion,
    ){}

    public function getQuestions(): array
    {
        return $this->userQuestion
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
    public function deleteQuestions(array $data): void
    {
        $this->userQuestion
            ->where('id', $data['id'])
            ->delete();
    }
    public function getCurrentQuestion(array $data): ?array
    {
        return $this->userQuestion
            ->where('id',$data['id'])
            ->first()
            ?->toArray();
    }
    public function updateQuestion(int $id, array $data): void
    {
        $this->userQuestion
            ->where('id',$id)
            ->update($data);
    }
}
