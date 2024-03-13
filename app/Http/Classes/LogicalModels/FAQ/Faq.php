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
        $categoryRes = [];
        $faqRes = [];
        foreach ($faq_category as $category) {
            $categoryTrans = [];
            $label = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function ($trans) use ($category) {
                    return $category['id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::RUS;
                }
            )['name'] ?? 'Нет на русском';
            foreach (Lang::ARRAY_LANG as $lang) {
                $trans = TransformArrayHelper::callbackSearchFirstInArray(
                    $faq_category_translations,
                    function ($trans) use ($category, $lang) {
                        return $category['id'] === $trans['faq_category_id']
                            && $trans['locale'] === $lang;
                    }
                );
                $categoryTrans[$lang] = $trans['name'] ?? '';
            }
            $categoryRes[] = [
                'label' => $label,
                ...$category,
                ...$categoryTrans,
            ];
        }
        foreach ($faqs as $faq){
            $faqTrans = [];
            $lable = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_translations,
                function($trans) use ($faq) {
                    return $faq['id'] === $trans['faq_id']
                        && $trans['locale'] === Lang::RUS;
                }
            );
            $categoryName = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function($trans) use ($faq) {
                    return $faq['faq_category_id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::RUS;
                });
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
            $faqRes[] = [
                'question' => $lable['question'] ?? 'Нет на русском',
                'answer' => $lable['answer'] ?? 'Нет на русском',
                'category_name' => $categoryName['name'] ?? 'Нет на русском',
                ...$faq,
                'tans' => $faqTrans,
            ];
        }
        return [
            'category' => $categoryRes,
            'faq' => $faqRes,
        ];
    }
    public function changeCategory(array $data): void
    {
        $this->model->updateCategoryProps($data);
        foreach ($data['locale'] as $key => $value)
        {
            $this->model->updateOrCreateCategoryTrans(
                id: $data['category_id'],
                lang: $key,
                text: $value
            );
        }

    }
}
