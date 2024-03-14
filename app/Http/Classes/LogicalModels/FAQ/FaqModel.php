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
    public function updateCategoryProps(array $data): void
    {
        $this->faq_category
            ->where('id', $data['category_id'])
            ->update([
                'position' => $data['position'],
                'status' => (int)$data['status'],
        ]);
    }
    public function updateOrCreateCategoryTrans(int $id,string $lang, string $text): void
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
    public function insertCategoryProps(array $data): int
    {
        return  $this->faq_category->insertGetId([
            'position' => $data['position'],
            'status' => (int)$data['status'],
            'created_at' => CDateTime::getCurrentDate(),
            'updated_at' => CDateTime::getCurrentDate(),
        ]);
    }
    public function deleteCategory(int $id): void
    {
        $this->faq_category->where('id',$id)->delete();
        $this->faq_category_translations->where('faq_category_id',$id)->delete();
    }
}


