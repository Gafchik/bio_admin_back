<?php

namespace App\Http\Classes\LogicalModels\News;

use App\Http\Classes\Structure\CDateTime;
use App\Http\Classes\Structure\Lang;
use App\Models\MySql\Biodeposit\News as NewsTable;
use App\Models\MySql\Biodeposit\News_translations;
use Illuminate\Database\Eloquent\Builder;

class NewsModel
{
    private const PER_PAGE = 10;
    public function __construct(
        private NewsTable $news,
        private News_translations $newsTranslations,
    ){}

    public function getItems(int $page): array
    {
        // Вычисляем смещение для выборки данных
        $offset = ($page - 1) * self::PER_PAGE;
        $nameRu = $this->getSubQuery(Lang::RUS,'name');
        $nameUk = $this->getSubQuery(Lang::UKR,'name');
        $nameEn = $this->getSubQuery(Lang::ENG,'name');
        $nameGe = $this->getSubQuery(Lang::GEO,'name');

        $shortContentRu = $this->getSubQuery(Lang::RUS,'short_content');
        $shortContentUk = $this->getSubQuery(Lang::UKR,'short_content');
        $shortContentEn = $this->getSubQuery(Lang::ENG,'short_content');
        $shortContentGe = $this->getSubQuery(Lang::GEO,'short_content');

        $contentRu = $this->getSubQuery(Lang::RUS,'content');
        $contentUk = $this->getSubQuery(Lang::UKR,'content');
        $contentEn = $this->getSubQuery(Lang::ENG,'content');
        $contentGe = $this->getSubQuery(Lang::GEO,'content');

        return $this->news->select([
            'id as id_card',
            'image',
            'view_count',
            'date',
            'status',
            'created_at',
        ])
            ->selectRaw("({$nameRu->toSql()}) as name_ru")
            ->mergeBindings($nameRu->getQuery())
            ->selectRaw("({$nameUk->toSql()}) as name_uk")
            ->mergeBindings($nameUk->getQuery())
            ->selectRaw("({$nameEn->toSql()}) as name_en")
            ->mergeBindings($nameEn->getQuery())
            ->selectRaw("({$nameGe->toSql()}) as name_ge")
            ->mergeBindings($nameGe->getQuery())
            ->selectRaw("({$shortContentRu->toSql()}) as short_content_ru")
            ->mergeBindings($shortContentRu->getQuery())
            ->selectRaw("({$shortContentUk->toSql()}) as short_content_uk")
            ->mergeBindings($shortContentUk->getQuery())
            ->selectRaw("({$shortContentEn->toSql()}) as short_content_en")
            ->mergeBindings($shortContentEn->getQuery())
            ->selectRaw("({$shortContentGe->toSql()}) as short_content_ge")
            ->mergeBindings($shortContentGe->getQuery())
            ->selectRaw("({$contentRu->toSql()}) as content_ru")
            ->mergeBindings($contentRu->getQuery())
            ->selectRaw("({$contentUk->toSql()}) as content_uk")
            ->mergeBindings($contentUk->getQuery())
            ->selectRaw("({$contentEn->toSql()}) as content_en")
            ->mergeBindings($contentEn->getQuery())
            ->selectRaw("({$contentGe->toSql()}) as content_ge")
            ->mergeBindings($contentGe->getQuery())
            ->orderByDesc('id')
            ->skip($offset)
            ->take(self::PER_PAGE)
            ->get()
            ->toArray();
    }
    private function getSubQuery(string $lang,string $filed): Builder
    {
        return $this->newsTranslations
            ->where('locale',$lang)
            ->whereRaw('news_id = id_card')
            ->select([$filed]);
    }
    public function getAllCount(): int
    {
        return $this->news->count();
    }
    public function edit(array $data): void
    {
        $this->news->getConnection()
            ->transaction(function () use ($data) {
                $this->news
                    ->where('id',$data['id'])
                    ->update([
                        'image' => $data['image'],
                        'date' => $data['date'],
                        'status' => $data['status'],
                    ]);
                foreach (Lang::ARRAY_LANG as $lang)
                {
                    $this->newsTranslations->updateOrCreate(
                        [
                            'news_id' => $data['id'],
                            'locale' => $lang,
                        ],
                        [
                            'name' => $data[$lang]['name'],
                            'short_content' => $data[$lang]['short_content'],
                            'content' => $data[$lang]['content'],
                        ]
                    );
                }
            });
    }
    public function delete(int $id): void
    {
        $this->news->getConnection()
            ->transaction(function () use ($id) {
                $this->news->where('id',$id)->delete();
                $this->newsTranslations->where('news_id',$id)->delete();
            });
    }
    public function add(array $data): int
    {
        $id = null;
        $this->news->getConnection()
            ->transaction(function () use ($data, &$id) {
                $id = $this->news
                    ->insertGetId([
                        'image' => $data['image'],
                        'date' => $data['date'],
                        'status' => $data['status'],
                        'view_count' => 0,
                        'created_at' => CDateTime::getCurrentDate(),
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                foreach (Lang::ARRAY_LANG as $lang)
                {
                    $this->newsTranslations->insert(
                        [
                            'news_id' => $id,
                            'locale' => $lang,
                            'name' => $data[$lang]['name'],
                            'short_content' => $data[$lang]['short_content'],
                            'content' => $data[$lang]['content'],
                            'meta_title' => null,
                            'meta_keywords' => null,
                            'meta_description' => null,
                        ]
                    );
                }
            });
        return $id;
    }
}
