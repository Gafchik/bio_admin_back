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
            $labelRu = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function ($trans) use ($category) {
                    return $category['id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::RUS;
                }
            )['name'] ?? 'Нет на русском';
            $labelEn = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function ($trans) use ($category) {
                    return $category['id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::ENG;
                }
            )['name'] ?? 'No in English';
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
                'label_ru' => $labelRu,
                'label_en' => $labelEn,
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
            $lable_ru = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_translations,
                function($trans) use ($faq) {
                    return $faq['id'] === $trans['faq_id']
                        && $trans['locale'] === Lang::RUS;
                }
            );
            $lable_en = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_translations,
                function($trans) use ($faq) {
                    return $faq['id'] === $trans['faq_id']
                        && $trans['locale'] === Lang::ENG;
                }
            );
            $categoryName_ru = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function($trans) use ($faq) {
                    return $faq['faq_category_id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::RUS;
                });
            $categoryName_en = TransformArrayHelper::callbackSearchFirstInArray(
                $faq_category_translations,
                function($trans) use ($faq) {
                    return $faq['faq_category_id'] === $trans['faq_category_id']
                        && $trans['locale'] === Lang::ENG;
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
                'question_ru' => $lable_ru['question'] ?? 'Нет на русском',
                'question_en' => $lable_en['question'] ?? 'No in English',
                'answer_ru' => $lable_ru['answer'] ?? 'Нет на русском',
                'answer_en' => $lable_en['answer'] ?? 'No in English',
                'category_name_ru' => $categoryName_ru['name'] ?? 'Нет на русском',
                'category_name_en' => $categoryName_en['name'] ?? 'No in English',
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
        $this->model->changeCategory($data);
    }
    public function addCategory(array $data): void
    {
        $this->model->addCategory($data);
    }
    public function deleteCategory(array $data): void
    {
        $this->model->deleteCategory(id: $data['category_id']);
    }
    public function changeFaq(array $data): void
    {
        $this->model->updateFaq($data);
    }
    public function addFaq(array $data): void
    {
        $this->model->addFaq($data);
    }
    public function deleteFaq(array $data): void
    {
        $this->model->deleteFaq(id: $data['question_id']);
    }
}
