<?php

namespace App\Http\Classes\MailModels\Question;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnswerQuestionMailModel extends Mailable
{
    use Queueable, SerializesModels;
    private const VIEW_PATH = 'mailView.Question.AnswerQuestion';
    private array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function build(): Mailable
    {
        return $this->subject('[no-reply] Ответ на вопрос')
            ->view(self::VIEW_PATH, $this->data);
    }

}
