<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class content extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Автоматическое создание slug при сохранении.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($content) {
            if (empty($content->slug)) {
                $content->slug = Str::slug($content->title);

                // Проверяем уникальность slug
                $originalSlug = $content->slug;
                $counter = 1;

                while (static::where('slug', $content->slug)->exists()) {
                    $content->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        static::updating(function ($content) {
            if ($content->isDirty('title') && empty($content->slug)) {
                $content->slug = Str::slug($content->title);

                // Проверяем уникальность slug
                $originalSlug = $content->slug;
                $counter = 1;

                while (static::where('slug', $content->slug)
                    ->where('id', '!=', $content->id)
                    ->exists()) {
                    $content->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });
    }

    /**
     * Scope для опубликованных записей.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope для поиска по slug.
     */
    public function scopeWhereSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Получить краткое описание (без HTML тегов).
     */
    public function getExcerptAttribute($length = 150)
    {
        $text = strip_tags($this->content);
        return Str::limit($text, $length);
    }

    /**
     * Получить первое изображение из контента.
     */
    public function getFirstImageAttribute()
    {
        preg_match('/<img[^>]+src="([^">]+)"/', $this->content, $matches);
        return $matches[1] ?? null;
    }
}
