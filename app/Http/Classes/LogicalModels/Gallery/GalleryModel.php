<?php

namespace App\Http\Classes\LogicalModels\Gallery;

use App\Http\Classes\LogicalModels\Gallery\Exceptions\AlbumNotFoundException;
use App\Http\Classes\Structure\CDateTime;
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
    public function editItemsAlbum(array $data, array $itemsToInsert): void
    {
        $this->images->getConnection()
            ->transaction(function () use ($data, $itemsToInsert) {
                //обновляем основную инфо про альбом
                $this->category_images
                    ->where('id', $data['id_album'])
                    ->update([
                        'status' => $data['status'],
                        'category_image' => $data['category_image'],
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                //обновляем локализацию альбома
                foreach (Lang::ARRAY_LANG as $lang)
                {
                    $this->category_image_translations->updateOrCreate(
                        [
                            'category_image_id' => $data['id_album'],
                            'locale' => $lang,
                        ],
                        [
                            'name' => $data['name_'.$lang],
                        ]
                    );
                }
                $this->images
                    ->where('category_id', $data['id_album'])
                    ->delete();
                foreach ($itemsToInsert as $item)
                {
                    $this->images->insert([
                        'category_id' => $data['id_album'],
                        'category_type' => 'App\Models\CategoryImage',
                        'video' => $item['video'] ?? null,
                        'image' => $item['image'] ?? null,
                        'status' => $item['status'] ?? true,
                        'position' => 0,
                        'lang' => $item['lang'] ?? null,
                        'created_at' => CDateTime::getCurrentDate(),
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                }
            });
    }
    public function addItemsAlbum(array $data, array $itemsToInsert): void
    {
        $this->images->getConnection()
            ->transaction(function () use ($data, $itemsToInsert) {
                $slug = $data['is_image'] ? $data['name_en'] : 'video_'.$data['name_en'];
                //обновляем основную инфо про альбом
                $id = $this->category_images
                    ->insertGetId([
                        'slug' => $slug,
                        'status' => $data['status'],
                        'category_image' => $data['category_image'],
                        'created_at' => CDateTime::getCurrentDate(),
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                //обновляем локализацию альбома
                foreach (Lang::ARRAY_LANG as $lang)
                {
                    $this->category_image_translations->updateOrCreate(
                        [
                            'category_image_id' => $id,
                            'locale' => $lang,
                        ],
                        [
                            'name' => $data['name_'.$lang],
                        ]
                    );
                }
                foreach ($itemsToInsert as $item)
                {
                    $this->images->insert([
                        'category_id' => $id,
                        'category_type' => 'App\Models\CategoryImage',
                        'video' => $item['video'] ?? null,
                        'image' => $item['image'] ?? null,
                        'status' => $item['status'] ?? true,
                        'position' => 0,
                        'lang' => $item['lang'] ?? null,
                        'created_at' => CDateTime::getCurrentDate(),
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                }
            });
    }
    public function deleteItemsAlbum(int $id): void
    {
        $this->images->getConnection()
            ->transaction(function () use ($id) {
                $this->category_images
                    ->where('id', $id)
                    ->delete();
                $this->category_image_translations
                    ->where('category_image_id', $id)
                    ->delete();
                $this->images
                    ->where('category_id',$id)
                    ->delete();
            });
    }
}
