<?php

namespace App\Models;

use App\Engines\Book\Converter\WikipediaItemConverter;
use App\Enums\BookTypeEnum;
use App\Traits\HasAuthors;
use App\Traits\HasBookFiles;
use App\Traits\HasCovers;
use App\Traits\HasFavorites;
use App\Traits\HasLanguage;
use App\Traits\HasReviews;
use App\Traits\HasSelections;
use App\Traits\HasTagsAndGenres;
use App\Traits\IsEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kiwilan\Steward\Queries\Filter\GlobalSearchFilter;
use Kiwilan\Steward\Services\Wikipedia\Wikipediable;
use Kiwilan\Steward\Services\Wikipedia\WikipediaItem;
use Kiwilan\Steward\Traits\HasMetaClass;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @property null|int $books_count
 * @property \App\Enums\BookTypeEnum|null $type
 */
class Serie extends Model implements HasMedia, Wikipediable
{
    use HasFactory;
    use HasAuthors;
    use IsEntity;
    use HasFavorites;
    use HasReviews;
    use HasLanguage;
    use HasTagsAndGenres;
    use HasCovers;
    use HasSelections;
    use HasMetaClass;
    use Searchable;
    use Queryable;
    use HasSearchableName;
    use HasBookFiles;

    protected $query_default_sort = 'slug_sort';

    protected $query_default_sort_direction = 'asc';

    protected $query_allowed_sorts = ['id', 'title', 'authors', 'books_count', 'language', 'created_at', 'updated_at', 'language'];

    protected $query_limit = 32;

    protected $fillable = [
        'title',
        'slug_sort',
        'slug',
        'type',
        'description',
        'link',
    ];

    protected $casts = [
        'type' => BookTypeEnum::class,
    ];

    protected $withCount = [
        'books',
    ];

    protected $with = [
        'authors',
        'language',
    ];

    /**
     * Relationships.
     */
    public function books(): HasMany
    {
        // Get Books into Serie, by volume order.
        return $this->hasMany(Book::class)
            ->where('is_hidden', false)
            ->orderBy('volume')
        ;
    }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        return $this->searchableNameAs();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'picture' => $this->cover_thumbnail,
            'author' => $this->authors_names,
            'description' => $this->description,
            'tags' => $this->tags_string,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function wikipediaConvert(WikipediaItem $item, bool $default = false): Wikipediable
    {
        WikipediaItemConverter::make($item, $this)
            ->setWikipediaDescription()
        ;
        $this->save();

        return $this;
    }

    protected function setQueryAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('q', new GlobalSearchFilter(['title'])),
            AllowedFilter::partial('title'),
            AllowedFilter::partial('authors'),
            AllowedFilter::exact('type'),
            AllowedFilter::scope('types', 'whereTypesIs'),
            AllowedFilter::callback(
                'language',
                fn (Builder $query, $value) => $query->whereHas(
                    'language',
                    fn (Builder $query) => $query->where('name', 'like', "%{$value}%")
                )
            ),
            AllowedFilter::scope('languages', 'whereLanguagesIs'),
            AllowedFilter::scope('language', 'whereLanguagesIs'),
        ];
    }
}
