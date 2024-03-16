<?php

namespace App\Http\Classes\LogicalModels\FAQ;

use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
use App\Http\Classes\Structure\CDateTime;
use App\Http\Classes\Structure\Lang;
use App\Models\MySql\Biodeposit\{
    Faq_translations,
    Faq,
    Faq_category,
    Faq_category_translations,
};

class FaqModel
{
    public function __construct(
       private Faq_translations $faq_translations,
       private Faq $faq,
       private Faq_category $faq_category,
       private Faq_category_translations $faq_category_translations,
    ){}
    public function getFaq(): array
    {
        return [
            'faq_category' => $this->faq_category->get()->toArray(),
            'faq_category_translations' => $this->faq_category_translations->get()->toArray(),
            'faqs' => $this->faq->get()->toArray(),
            'faq_translations' => $this->faq_translations->get()->toArray(),
        ];
    }
    public function changeCategory(array $data): void
    {
        $this->faq_category->getConnection()
            ->transaction(function () use ($data) {
                $this->faq_category
                    ->where('id', $data['category_id'])
                    ->update([
                        'position' => $data['position'],
                        'status' => (int)$data['status'],
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                foreach ($data['locale'] as $lang => $text)
                {
                    $this->faq_category_translations->updateOrCreate(
                        [
                            'faq_category_id' => $data['category_id'],
                            'locale' => $lang,
                        ],
                        [
                            'name' => $text
                        ]
                    );
                }
            });
    }
    public function addCategory(array $data): void
    {
        $this->faq_category->getConnection()
            ->transaction(function () use ($data) {
                $id = $this->faq_category->insertGetId([
                    'position' => $data['position'],
                    'status' => (int)$data['status'],
                    'created_at' => CDateTime::getCurrentDate(),
                    'updated_at' => CDateTime::getCurrentDate(),
                ]);
                foreach ($data['locale'] as $lang => $text)
                {
                    $this->faq_category_translations->updateOrCreate(
                        [
                            'faq_category_id' => $id,
                            'locale' => $lang,
                        ],
                        [
                            'name' => $text
                        ]
                    );
                }
            });

    }
    public function deleteCategory(int $id): void
    {
        $this->faq_category->getConnection()
            ->transaction(function () use ($id) {
                $this->faq_category->where('id',$id)->delete();
                $this->faq_category_translations->where('faq_category_id',$id)->delete();
            });
    }
    public function updateFaq(array $data): void
    {
        $this->faq->getConnection()
            ->transaction(function () use ($data) {
                $this->faq
                    ->where('id',$data['question_id'])
                    ->update([
                        'faq_category_id' => $data['category_id'],
                        'position' => $data['position'],
                        'status' => (int)$data['status'],
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                foreach ($data['locale_question'] as $lang => $text)
                {
                    $this->faq_translations->updateOrCreate(
                        [
                            'faq_id' => $data['question_id'],
                            'locale' => $lang,
                        ],
                        [
                            'question' => $text
                        ]
                    );
                }
                foreach ($data['locale_answer'] as $lang => $text)
                {
                    $this->faq_translations->updateOrCreate(
                        [
                            'faq_id' => $data['question_id'],
                            'locale' => $lang,
                        ],
                        [
                            'answer' => $text
                        ]
                    );
                }
            });

    }
    public function addFaq(array $data): void
    {
        $this->faq->getConnection()
            ->transaction(function () use ($data) {
                $id = $this->faq->insertGetId([
                    'faq_category_id' => $data['category_id'],
                    'position' => $data['position'],
                    'status' => (int)$data['status'],
                    'created_at' => CDateTime::getCurrentDate(),
                    'updated_at' => CDateTime::getCurrentDate(),
                ]);
                foreach ($data['locale_question'] as $lang => $text)
                {
                    $this->faq_translations->updateOrCreate(
                        [
                            'faq_id' => $id,
                            'locale' => $lang,
                        ],
                        [
                            'question' => $text
                        ]
                    );
                }
                foreach ($data['locale_answer'] as $lang => $text)
                {
                    $this->faq_translations->updateOrCreate(
                        [
                            'faq_id' => $id,
                            'locale' => $lang,
                        ],
                        [
                            'answer' => $text
                        ]
                    );
                }
            });
    }
    public function deleteFaq(int $id): void
    {
        $this->faq->getConnection()
            ->transaction(function () use ($id) {
                $this->faq->where('id',$id)->delete();
                $this->faq_translations->where('faq_id',$id)->delete();
            });
    }
}


