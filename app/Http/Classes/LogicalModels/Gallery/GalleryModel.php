<?php

namespace App\Http\Classes\LogicalModels\Gallery;

use App\Http\Classes\Structure\Lang;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MySql\Biodeposit\{
    Images,
    Category_images,
    Category_image_translations,
};

class GalleryModel
{
    public function __construct(
        private Images  $images,
        private Category_images  $category_images,
        private Category_image_translations $category_image_translations,
    ){}

    public function getItems(): array
    {
        $nameRu = $this->getSubQuery(Lang::RUS,'name');
        $nameUk = $this->getSubQuery(Lang::UKR,'name');
        $nameEn = $this->getSubQuery(Lang::ENG,'name');
        $nameGe = $this->getSubQuery(Lang::GEO,'name');
        return $this->category_images->select([
            'id as id_album',
            'status',
        ])
            ->selectRaw("({$nameRu->toSql()}) as name_ru")
            ->mergeBindings($nameRu->getQuery())
            ->selectRaw("({$nameUk->toSql()}) as name_uk")
            ->mergeBindings($nameUk->getQuery())
            ->selectRaw("({$nameEn->toSql()}) as name_en")
            ->mergeBindings($nameEn->getQuery())
            ->selectRaw("({$nameGe->toSql()}) as name_ge")
            ->mergeBindings($nameGe->getQuery())
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
    private function getSubQuery(string $lang,string $filed): Builder
    {
        return $this->category_image_translations
            ->where('locale',$lang)
            ->whereRaw('category_image_id = id_album')
            ->select([$filed]);
    }
}
