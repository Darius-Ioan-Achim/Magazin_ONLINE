<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    use HasFactory;

    // Numele tabelei
    protected $table = 'order_items';

    // Campurile care pot fi completate in masa
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'unit_price',
        'total_price'
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

    // Reguli de validare simple
    public static function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ];
    }

    // Relatia cu comanda - un item apartine unei comenzi
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relatia cu cartea - un item apartine unei carti
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

    // Mutator pentru a calcula pretul total cand se schimba pretul unitar
    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value;
        if (isset($this->attributes['quantity'])) {
            $this->attributes['total_price'] = $this->attributes['quantity'] * $value;
        }
    }

    // Scope pentru itemii unei comenzi
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    // Scope pentru itemii unei carti
    public function scopeForBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    // Metoda pentru a crea un item nou in comanda
    public static function createItem($orderId, $bookId, $quantity, $unitPrice)
    {
        return self::create([
            'order_id' => $orderId,
            'book_id' => $bookId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $quantity * $unitPrice
        ]);
    }

    // Metoda pentru a adauga mai multe items dintr-o data
    public static function createMultipleItems($orderId, $items)
    {
        $orderItems = [];
        
        foreach ($items as $item) {
            $orderItems[] = [
                'order_id' => $orderId,
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        return self::insert($orderItems);
    }

    // Metoda pentru a obtine itemii unei comenzi cu detalii despre carti
    public static function getOrderItemsWithBooks($orderId)
    {
        return self::forOrder($orderId)->with('book')->get();
    }

    // Metoda pentru a obtine totalul unei comenzi
    public static function getOrderTotal($orderId)
    {
        return self::forOrder($orderId)->sum('total_price');
    }

    // Metoda pentru a obtine cantitatea totala de carti dintr-o comanda
    public static function getOrderQuantity($orderId)
    {
        return self::forOrder($orderId)->sum('quantity');
    }

    // Metoda pentru a actualiza cantitatea unui item
    public function updateQuantity($newQuantity)
    {
        $this->quantity = $newQuantity;
        $this->calculateTotalPrice();
        return $this->save();
    }

    // Metoda pentru a verifica daca itemul poate fi sters
    public function canBeDeleted()
    {
        // Verifica daca comanda nu este finalizata
        return $this->order && $this->order->canBeCancelled();
    }

    // Metoda pentru a obtine informatii despre carte
    public function getBookInfo()
    {
        return $this->book ? [
            'title' => $this->book->title,
            'author' => $this->book->author,
            'isbn' => $this->book->isbn ?? 'N/A'
        ] : null;
    }

    // Metoda pentru a obtine economii (daca pretul actual e diferit de cel din comanda)
    public function getSavings()
    {
        if ($this->book && $this->book->price) {
            $currentPrice = $this->book->price;
            $paidPrice = $this->unit_price;
            return ($currentPrice - $paidPrice) * $this->quantity;
        }
        return 0;
    }

    // Accessor pentru pretul total formatat
    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 2) . ' lei';
    }

    // Accessor pentru pretul unitar formatat
    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 2) . ' lei';
    }

    // Metoda pentru a obtine informatii complete despre item
    public function getItemDetails()
    {
        return [
            'id' => $this->id,
            'book_title' => $this->book->title ?? 'Carte necunoscuta',
            'quantity' => $this->quantity,
            'unit_price' => $this->formatted_unit_price,
            'total_price' => $this->formatted_total_price,
            'book_info' => $this->getBookInfo()
        ];
    }

    // Metoda pentru a copia itemii dintr-o comanda in alta
    public static function copyItemsToOrder($fromOrderId, $toOrderId)
    {
        $items = self::forOrder($fromOrderId)->get();
        
        foreach ($items as $item) {
            self::createItem(
                $toOrderId,
                $item->book_id,
                $item->quantity,
                $item->unit_price
            );
        }
        
        return true;
    }

    // Metoda toString pentru afisare
    public function __toString()
    {
        return $this->book->title . ' (x' . $this->quantity . ')';
    }
}
