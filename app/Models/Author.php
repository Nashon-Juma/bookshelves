<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Author.
 *
 * @property int                                                                                                                           $id
 * @property string|null                                                                                                                   $slug
 * @property string|null                                                                                                                   $lastname
 * @property string|null                                                                                                                   $firstname
 * @property string|null                                                                                                                   $name
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Book[]                                                                   $books
 * @property int|null                                                                                                                      $books_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[]                                                                $comments
 * @property int|null                                                                                                                      $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\User[]                                                                   $favorites
 * @property int|null                                                                                                                      $favorites_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property int|null                                                                                                                      $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @mixin \Eloquent
 * @property-read string $download_link
 * @property-read string|null $image
 * @property-read string $show_link
 * @property-read string|null $image_thumbnail
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $series
 * @property-read int|null $series_count
 */
class Author extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'slug',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $formatBasic = config('image.thumbnails.book_cover');
        $formatThumbnail = config('image.thumbnails.book_thumbnail');
        $formatStandard = config('image.thumbnails.book_standard');

        $this->addMediaConversion('basic')
            ->fit(Manipulations::FIT_CROP, $formatBasic['width'], $formatBasic['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, $formatThumbnail['width'], $formatThumbnail['height'])
            ->format(config('bookshelves.cover_extension'));

        $this->addMediaConversion('standard')
            ->crop(Manipulations::CROP_TOP, $formatStandard['width'], $formatStandard['height'])
            ->format('jpg');
    }

    public function getImageAttribute(): string|null
    {
        return $this->getMedia('authors')->first()?->getUrl('basic');
    }

    public function getImageThumbnailAttribute(): string|null
    {
        return $this->getMedia('authors')->first()?->getUrl('thumbnail');
    }

    public function getImageStandardAttribute(): string|null
    {
        return $this->getMedia('authors')->first()?->getUrl('standard');
    }

    public function getShowLinkAttribute(): string
    {
        $route = route('api.authors.show', [
            'author' => $this->slug,
        ]);
        return $route;
    }

    public function getDownloadLinkAttribute(): string
    {
        $route = route('api.download.author', [
            'author' => $this->slug,
        ]);
        return $route;
    }

    public function favorites(): MorphToMany
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get all of the books that are assigned this author.
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable')->orderBy('serie_id')->orderBy('serie_number');
    }

    /**
     * Get all of the series that are assigned this author.
     */
    public function series(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'authorable');
    }
}
