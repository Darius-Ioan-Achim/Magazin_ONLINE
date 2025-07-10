<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
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

    /**
     * Relația Many-to-Many cu User (utilizatori care au împrumutat/cumpărat cartea)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_user')
                    ->withTimestamps()
                    ->withPivot(['borrowed_at', 'returned_at', 'status']);
    }

    /**
     * Relația cu Category (o carte aparține unei categorii)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relația cu Genre (o carte aparține unui gen)
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Relația cu Author (dacă ai tabel separat pentru autori)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Relația cu Publisher (dacă ai tabel separat pentru edituri)
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * Relația cu Reviews (o carte poate avea multe review-uri)
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relația cu Orders prin pivot (comenzi care conțin această carte)
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_book')
                    ->withPivot(['quantity', 'price'])
                    ->withTimestamps();
    }

    /**
     * Relația cu Tags (o carte poate avea mai multe tag-uri)
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'book_tag');
    }

    /**
     * Scope pentru cărți active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pentru cărți disponibile în stoc
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope pentru cărți active și în stoc
     */
    public function scopeAvailable($query)
    {
        return $query->active()->inStock();
    }

    /**
     * Scope pentru cărți dintr-o anumită categorie
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope pentru cărți dintr-un anumit gen
     */
    public function scopeByGenre($query, $genreId)
    {
        return $query->where('genre_id', $genreId);
    }

    /**
     * Scope pentru căutare după titlu sau autor
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                    ->orWhere('author', 'like', "%{$term}%");
    }

    /**
     * Scope pentru filtrare după preț
     */
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * Accessor pentru URL-ul imaginii
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/no-book-cover.jpg');
    }

    /**
     * Accessor pentru rating-ul mediu
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Accessor pentru statusul stocului
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= 5) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    /**
     * Accessor pentru verificarea disponibilității
     */
    public function getIsAvailableAttribute()
    {
        return $this->is_active && $this->stock > 0;
    }

    /**
     * Mutator pentru titlu (capitalizează prima literă)
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst(trim($value));
    }

    /**
     * Mutator pentru autor (capitalizează prima literă)
     */
    public function setAuthorAttribute($value)
    {
        $this->attributes['author'] = ucfirst(trim($value));
    }

    /**
     * Mutator pentru ISBN (elimină spațiile)
     */
    public function setIsbnAttribute($value)
    {
        $this->attributes['isbn'] = $value ? str_replace([' ', '-'], '', $value) : null;
    }
}