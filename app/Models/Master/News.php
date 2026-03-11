<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'author_user_id',
        'board_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Отношение к автору (пользователю).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_user_id');
    }

    /**
     * Отношение к доске (board).
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    /**
     * Scope для опубликованных новостей.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    /**
     * Scope для новостей определенной доски.
     */
    public function scopeForBoard($query, $boardId)
    {
        return $query->where('board_id', $boardId);
    }

    /**
     * Scope для новостей без привязки к доске.
     */
    public function scopeWithoutBoard($query)
    {
        return $query->whereNull('board_id');
    }

    /**
     * Scope для новостей с пагинацией.
     */
    public function scopePaginated($query, $perPage = 10)
    {
        return $query->published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Scope для последних новостей.
     */
    public function scopeLatestNews($query, $limit = 5)
    {
        return $query->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit);
    }

    /**
     * Получить URL изображения.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/news/'.$this->image);
    }

    /**
     * Проверить, опубликована ли новость.
     */
    public function isPublished(): bool
    {
        return $this->is_published && $this->published_at <= now();
    }

    /**
     * Проверить, привязана ли новость к доске.
     */
    public function hasBoard(): bool
    {
        return null !== $this->board_id;
    }

    /**
     * Опубликовать новость.
     */
    public function publish(): void
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    /**
     * Снять с публикации.
     */
    public function unpublish(): void
    {
        $this->update(['is_published' => false]);
    }

    /**
     * Привязать к доске.
     */
    public function attachToBoard($boardId): void
    {
        $this->update(['board_id' => $boardId]);
    }

    /**
     * Отвязать от доски.
     */
    public function detachFromBoard(): void
    {
        $this->update(['board_id' => null]);
    }

    /**
     * Получить краткое содержание (если excerpt пустой, обрезаем content).
     */
    public function getShortExcerptAttribute($length = 150): string
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        return Str::limit(strip_tags($this->content), $length);
    }
}
