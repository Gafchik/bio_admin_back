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
        foreach (Lang::ARRAY_LANG as $lang){
            foreach ($faq_category as $category){
                $allTranslate = TransformArrayHelper::callbackSearchAllInArray(
                    $faq_category_translations,
                    function($trans) use ($category,$lang) {
                        return $category['id'] === $trans['faq_category_id']
                            && $trans['locale'] === $lang;
                    }
                );
                if(!empty($allTranslate)){
                    $result[$lang]['category'][] = array_shift($allTranslate);
                }
            }
            foreach ($faqs as $item){
                foreach ($faq_translations as $trans){
                    if(
                        $item['id'] === $trans['faq_id']
                        && $trans['locale'] === $lang
                    ){
                        $result[$lang]['faq'][] = [
                            'faq_category_id' => $item['faq_category_id'],
                            ...$trans
                        ];
                    }
                }
            }
        }
        return $result;
    }
}
