<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;

    // Numele tabelei
    protected $table = 'carts';

    // Campurile care pot fi completate in masa
    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'unit_price',
        'total_price',
        'status'
    ];

    // Campurile protejate
    protected $guarded = [
        'id'
    ];

    // Tipurile de date pentru campuri
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Valorile default pentru anumite campuri
    protected $attributes = [
        'quantity' => 1,
        'status' => 'active'
    ];

    // Statusurile posibile pentru cos
    const STATUS_ACTIVE = 'active';
    const STATUS_ORDERED = 'ordered';
    const STATUS_SAVED_FOR_LATER = 'saved_for_later';

    // Reguli de validare simple
    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,ordered,saved_for_later'
        ];
    }

    // Relatia cu userul - un item din cos apartine unui user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatia cu cartea - un item din cos apartine unei carti
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Metoda pentru a calcula pretul total automat
    public function calculateTotalPrice()
    {
        $this->total_price = $this->quantity * $this->unit_price;
        return $this;
    }

    // Mutator pentru a calcula pretul total cand se schimba cantitatea
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        if (isset($this->attributes['unit_price'])) {
            $this->attributes['total_price'] = $value * $this->attributes['unit_price'];
        }
    }

    // Scope pentru cosul activ al unui user
    public function scopeActiveForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('status', 'active');
    }

    // Scope pentru itemii salvati pentru mai tarziu
    public function scopeSavedForLater($query, $userId)
    {
        return $query->where('user_id', $userId)->where('status', 'saved_for_later');
    }

    // Scope pentru itemii comandati
    public function scopeOrdered($query, $userId)
    {
        return $query->where('user_id', $userId)->where('status', 'ordered');
    }

    // Metoda pentru a obtine cosul activ al unui user
    public static function getActiveCart($userId)
    {
        return self::activeForUser($userId)->with('book')->get();
    }

    // Metoda pentru a obtine totalul cosului activ
    public static function getCartTotal($userId)
    {
        return self::activeForUser($userId)->sum('total_price');
    }

    // Metoda pentru a obtine numarul total de carti din cos
    public static function getCartItemsCount($userId)
    {
        return self::activeForUser($userId)->sum('quantity');
    }

    // Metoda pentru a adauga o carte in cos sau actualiza cantitatea
    public static function addToCart($userId, $bookId, $quantity = 1, $unitPrice)
    {
        $cartItem = self::where('user_id', $userId)
                       ->where('book_id', $bookId)
                       ->where('status', 'active')
                       ->first();

        if ($cartItem) {
            // Daca exista, actualizam cantitatea
            $cartItem->quantity += $quantity;
            $cartItem->calculateTotalPrice();
            $cartItem->save();
        } else {
            // Daca nu exista, cream un item nou
            $cartItem = self::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $quantity * $unitPrice,
                'status' => 'active'
            ]);
        }

        return $cartItem;
    }

    // Metoda pentru a sterge un item din cos
    public static function removeFromCart($userId, $bookId)
    {
        return self::where('user_id', $userId)
                   ->where('book_id', $bookId)
                   ->where('status', 'active')
                   ->delete();
    }

    // Metoda pentru a goli cosul
    public static function clearCart($userId)
    {
        return self::where('user_id', $userId)
                   ->where('status', 'active')
                   ->delete();
    }

    // Metoda pentru a salva pentru mai tarziu
    public function saveForLater()
    {
        $this->status = 'saved_for_later';
        return $this->save();
    }

    // Metoda pentru a muta inapoi in cos
    public function moveToActiveCart()
    {
        $this->status = 'active';
        return $this->save();
    }
}
