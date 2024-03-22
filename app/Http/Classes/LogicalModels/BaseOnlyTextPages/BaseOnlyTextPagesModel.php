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
    public function edit(array $data): void
    {
        $this->pageTranslation->getConnection()
            ->transaction(function () use ($data) {
                foreach ($data['lang'] as $lang => $text)
                {
                    if(!empty($text)){
                        $this->pageTranslation->updateOrCreate(
                            [
                                'page_id' => $data['id'],
                                'locale' => $lang,
                            ],
                            [
                                'content' => $text,
                            ]
                        );
                    }
                }
            });
    }
}
