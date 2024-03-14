<?php

namespace App\Http\Classes\LogicalModels\FAQ;

use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
use App\Http\Classes\Structure\Lang;

class Faq
{
    public function __construct(
        private FaqModel $model,
    ){}

    public function getFaq()
    {
        $data = $this->model->getFaq();
        return [
            ...$this->prepareResponseCategory(
                faq_category: $data['faq_category'],
                faq_category_translations: $data['faq_category_translations'],
            ),
            ...$this->prepareResponseQuestion(
                faqs: $data['faqs'],
                faq_translations: $data['faq_translations'],
                faq_category_translations: $data['faq_category_translations'],
            )
        ];
    }
    public function getFaqCategory(): array
    {
        $data = $this->model->getFaq();
        return $this->prepareResponseCategory(
            faq_category: $data['faq_category'],
            faq_category_translations: $data['faq_category_translations'],
        );
    }
    private function prepareResponseCategory(
        array $faq_category,
        array $faq_category_translations,
    ): array
    {
        $categoryRes = [];
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
        return [
            'category' => $categoryRes,
        ];
    }
    public function getFaqQuestion(): array
    {
        $data = $this->model->getFaq();
        return $this->prepareResponseQuestion(
            faqs: $data['faqs'],
            faq_translations: $data['faq_translations'],
            faq_category_translations: $data['faq_category_translations'],
        );
    }

    private function prepareResponseQuestion(
        array $faqs,
        array $faq_translations,
        array $faq_category_translations,
    ): array
    {
        $faqRes = [];
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
                $faqTrans[$lang] = [
                    'question' => $trans['question'] ?? '',
                    'answer' => $trans['answer'] ?? '',
                ];
            }
            $faqRes[] = [
                'question' => $lable['question'] ?? 'Нет на русском',
                'answer' => $lable['answer'] ?? 'Нет на русском',
                'category_name' => $categoryName['name'] ?? 'Нет на русском',
                ...$faq,
                ...$faqTrans,
            ];
        }
        return [
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
    public function addCategory(array $data): void
    {
        $id = $this->model->insertCategoryProps($data);
        foreach ($data['locale'] as $key => $value)
        {
            $this->model->updateOrCreateCategoryTrans(
                id: $id,
                lang: $key,
                text: $value
            );
        }
    }
    public function deleteCategory(array $data): void
    {
        $this->model->deleteCategory(id: $data['category_id']);
    }
}
