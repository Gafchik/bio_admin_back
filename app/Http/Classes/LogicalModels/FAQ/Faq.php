<?php

namespace App\Http\Classes\LogicalModels\FAQ;

use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
use App\Http\Classes\Structure\Lang;

class Faq
{
    public function __construct(
        private FaqModel $model,
    ){}
    public function getFaq(): array
    {
        $data = $this->model->getFaq();
        return $this->prepareResponse(
            faqs: $data['faqs'],
            faq_translations: $data['faq_translations'],
            faq_category: $data['faq_category'],
            faq_category_translations: $data['faq_category_translations'],
        );
    }
    private function prepareResponse(
        array $faqs,
        array $faq_translations,
        array $faq_category,
        array $faq_category_translations,
    ): array
    {
        $result = [];
        foreach ($faq_category as $category){
            $categoryTrans = [];
            foreach (Lang::ARRAY_LANG as $lang){
                $trans = TransformArrayHelper::callbackSearchFirstInArray(
                    $faq_category_translations,
                    function($trans) use ($category,$lang) {
                        return $category['id'] === $trans['faq_category_id']
                            && $trans['locale'] === $lang;
                    }
                );
                $categoryTrans[] = $trans ?? ['locale' => $lang];
            }
            $faqRes = [];
            foreach ($faqs as $faq){
                $faqTrans = [];
                foreach (Lang::ARRAY_LANG as $lang){
                    $trans = TransformArrayHelper::callbackSearchFirstInArray(
                        $faq_translations,
                        function($trans) use ($faq,$lang) {
                            return $faq['id'] === $trans['faq_id']
                                && $trans['locale'] === $lang;
                        }
                    );
                    $faqTrans[] = $trans ?? ['locale' => $lang];
                }
                $faqRes = [
                    'tans' => $faqTrans,
                    ...$faq
                ];
            }
            $result[] = [
                ...$category,
                'trans' => $categoryTrans,
                'faq' => $faqRes
            ];
        }
        return $result;
    }
}
