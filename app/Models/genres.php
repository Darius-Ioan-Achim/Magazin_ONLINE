<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Relația cu cărțile din acest gen
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Obține numărul de cărți din acest gen
     */
    public function getBooksCountAttribute(): int
    {
        return $this->books()->count();
    }

    /**
     * Obține numărul de cărți active din acest gen
     */
    public function getActiveBooksCountAttribute(): int
    {
        return $this->books()->active()->count();
    }

    /**
     * Obține numărul de cărți disponibile din acest gen
     */
    public function getAvailableBooksCountAttribute(): int
    {
        return $this->books()->available()->count();
    }

    /**
     * Scope pentru genuri cu cărți
     */
    public function scopeWithBooks($query)
    {
        return $query->whereHas('books');
    }

    /**
     * Scope pentru genuri cu cărți active
     */
    public function scopeWithActiveBooks($query)
    {
        return $query->whereHas('books', function($query) {
            $query->active();
        });
    }

    /**
     * Scope pentru genuri cu cărți disponibile
     */
    public function scopeWithAvailableBooks($query)
    {
        return $query->whereHas('books', function($query) {
            $query->available();
        });
    }

    /**
     * Obține genurile cu numărul de cărți
     */
    public function scopeWithBooksCount($query)
    {
        return $query->withCount('books');
    }

    /**
     * Obține genurile cu numărul de cărți active
     */
    public function scopeWithActiveBooksCount($query)
    {
        return $query->withCount(['books as active_books_count' => function($query) {
            $query->active();
        }]);
    }

    /**
     * Obține genurile cu numărul de cărți disponibile
     */
    public function scopeWithAvailableBooksCount($query)
    {
        return $query->withCount(['books as available_books_count' => function($query) {
            $query->available();
        }]);
    }
}