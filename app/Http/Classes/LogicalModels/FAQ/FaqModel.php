<?php

namespace App\Http\Classes\LogicalModels\FAQ;

use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
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
            'faqs' => $this->faq->get()->toArray(),
            'faq_translations' => $this->faq_translations->get()->toArray(),
            'faq_category' => $this->faq_category->get()->toArray(),
            'faq_category_translations' => $this->faq_category_translations->get()->toArray(),
        ];
    }
}
