<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class book_user extends Model
{
    // Numele tabelei
    protected $table = 'book_user';

    // Ce campuri pot fi completate
    protected $fillable = [
        'user_id',
        'book_id'
    ];

    // Legaturile cu alte tabele
    
    // Un record apartine unui user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un record apartine unei carti
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Adauga carte la favorite
    public static function addFavorite($userId, $bookId)
    {
        return self::create([
            'user_id' => $userId,
            'book_id' => $bookId
        ]);
    }

    // Sterge carte din favorite
    public static function removeFavorite($userId, $bookId)
    {
        return self::where('user_id', $userId)
                   ->where('book_id', $bookId)
                   ->delete();
    }

    // Verifica daca cartea este la favorite
    public static function isFavorite($userId, $bookId)
    {
        return self::where('user_id', $userId)
                   ->where('book_id', $bookId)
                   ->exists();
    }

    // Obtine cartile favorite ale unui user
    public static function getFavorites($userId)
    {
        return self::where('user_id', $userId)->with('book')->get();
    }
}
