<?php

namespace App\Http\Classes\LogicalModels\BaseOnlyTextPages;

use App\Models\MySql\Biodeposit\Page_translations;

class BaseOnlyTextPagesModel
{
    public function __construct(
        private Page_translations $pageTranslation
    ){}

    public function get(int $id): array
    {
        return $this->pageTranslation
            ->where('page_id',$id)
            ->get([
                'locale',
                'content'
            ])
            ->toArray();
    }
}
