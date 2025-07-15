<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class books extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'isbn',
        'stock',
        'price',
        'image_path',
        'is_active',
        'category_id',
        'genre_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relații
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Metode helper
    public function isAvailable(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' RON';
    }

    // Scope-uri pentru query-uri
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeAvailable($query)
    {
        return $query->active()->inStock();
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByGenre($query, $genreId)
    {
        return $query->where('genre_id', $genreId);
    }

    public function scopeByAuthor($query, $author)
    {
        return $query->where('author', 'like', '%' . $author . '%');
    }

    public function scopeSearchByTitle($query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    // Metode pentru stock management
    public function decreaseStock(int $quantity = 1): bool
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            return $this->save();
        }
        return false;
    }

    public function increaseStock(int $quantity = 1): bool
    {
        $this->stock += $quantity;
        return $this->save();
    }
}
