<?php

namespace App\Models\Traits;

use App\Models\Author;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Get authors
 * - with author for meta
 * - a string with all authors seperated by a comma
 * - API links: `show`, `show-opds`, `download-link`,`webreader-link`.
 */
trait HasAuthors
{
    public function scopeWhereAuthorIsLike(Builder $query, string $author): Builder
    {
        return $query->whereHas('authors', function (Builder $query) use ($author) {
            $query->where('name', 'LIKE', "%{$author}%");
        });
    }

    /**
     * Get first Author of entity, used for URL like `...author-slug/entity-slug`.
     */
    public function getMetaAuthorAttribute(): string|null
    {
        $author = $this->authors->first();

        return $author->slug;
    }

    /**
     * Get Authors of entity.
     */
    public function authors(): MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function getAuthorsNamesAttribute(): string
    {
        $authors = [];
        foreach ($this->authors as $key => $author) {
            array_push($authors, $author->name);
        }

        return implode(', ', $authors);
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.v1.'.$this->getClassName(true).'.show', [
            'author_slug' => $this->meta_author,
            "{$this->getClassName()}_slug" => $this->slug,
        ]);
    }

    public function getShowLinkOpdsAttribute(): string
    {
        return route('features.opds.'.$this->getClassName(true).'.show', [
            'version' => 'v1.2',
            'author' => $this->meta_author,
            $this->getClassName() => $this->slug,
        ]);
    }

    public function getDownloadLinkAttribute(): string
    {
        return route('api.v1.download.'.$this->getClassName(), [
            'author_slug' => $this->meta_author,
            "{$this->getClassName()}_slug" => $this->slug,
        ]);
    }

    public function getWebreaderLinkAttribute(): string
    {
        if ($this->meta_author && $this->slug) {
            return route('features.webreader.reader', [
                'author' => $this->meta_author,
                $this->getClassName() => $this->slug,
            ]);
        }

        return '';
    }
}
