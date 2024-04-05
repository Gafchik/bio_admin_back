<?php

namespace App\Http\Classes\LogicalModels\Gallery;

use App\Http\Classes\LogicalModels\Gallery\Exceptions\AlbumNotFoundException;
use App\Http\Classes\Structure\Lang;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MySql\Biodeposit\{
    Images,
    Category_images,
    Category_image_translations,
};
use function PHPUnit\Framework\isNull;

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
    public function getItemsAlbum(int $id): array
    {
        $categoryImages = $this->getBaseData($id);
        if(is_null($categoryImages)){
            throw new AlbumNotFoundException();
        }
        $items = $this->getAlbumsDetail($id);
        if(empty($items)){
            throw new AlbumNotFoundException();
        }
        return [
            ...$categoryImages,
            'items' => $items
        ];
    }
    private function getBaseData(int $id): ?array
    {
        $nameRu = $this->getSubQuery(Lang::RUS,'name');
        $nameUk = $this->getSubQuery(Lang::UKR,'name');
        $nameEn = $this->getSubQuery(Lang::ENG,'name');
        $nameGe = $this->getSubQuery(Lang::GEO,'name');
        return  $this->category_images
            ->select([
                'id as id_album',
                'category_image',
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
            ->selectRaw("IF(slug LIKE '%video%', 0, 1) as is_image")
            ->where('id',$id)
            ->first()
            ?->toArray();
    }
    private function getAlbumsDetail(int $id): array
    {
        return $this->images
            ->select([
                'id',
                'video',
                'image',
                'status',
                'lang',
            ])
            ->where('category_id',$id)
            ->get()
            ->toArray();
    }
}
