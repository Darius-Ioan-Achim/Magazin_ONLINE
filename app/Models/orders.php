<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
     use HasFactory;

    // Numele tabelei
    protected $table = 'orders';

    // Campurile care pot fi completate in masa
    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address',
        'ordered_at',
        'shipped_at',
        'delivered_at'
    ];

    // Campurile protejate
    protected $guarded = [
        'id'
    ];

    // Tipurile de date pentru campuri
    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'ordered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Valorile default pentru anumite campuri
    protected $attributes = [
        'status' => 'pending'
    ];

    // Statusurile posibile pentru comanda
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    // Reguli de validare simple
    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'ordered_at' => 'required|date'
        ];
    }

    // Relatia cu userul - o comanda apartine unui user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatia cu itemii comenzii (presupunem ca avem un tabel order_items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Genereaza un numar unic de comanda
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (self::where('order_number', $orderNumber)->exists());
        
        return $orderNumber;
    }

    // Metoda pentru a crea o comanda noua
    public static function createOrder($userId, $totalAmount, $shippingAddress, $billingAddress = null)
    {
        return self::create([
            'order_number' => self::generateOrderNumber(),
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress ?? $shippingAddress,
            'ordered_at' => now(),
            'status' => 'pending'
        ]);
    }

    // Scope pentru comenzile unui user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope pentru comenzile cu un anumit status
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope pentru comenzile din ultima luna
    public function scopeRecent($query)
    {
        return $query->where('ordered_at', '>=', now()->subMonth());
    }

    // Metoda pentru a confirma comanda
    public function confirm()
    {
        $this->status = 'confirmed';
        return $this->save();
    }

    // Metoda pentru a marca comanda ca expedita
    public function markAsShipped()
    {
        $this->status = 'shipped';
        $this->shipped_at = now();
        return $this->save();
    }

    // Metoda pentru a marca comanda ca livrata
    public function markAsDelivered()
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        return $this->save();
    }

    // Metoda pentru a anula comanda
    public function cancel()
    {
        if (in_array($this->status, ['pending', 'confirmed'])) {
            $this->status = 'cancelled';
            return $this->save();
        }
        return false;
    }

    // Verifica daca comanda poate fi anulata
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // Verifica daca comanda este finalizata
    public function isCompleted()
    {
        return $this->status === 'delivered';
    }

    // Verifica daca comanda este activa
    public function isActive()
    {
        return !in_array($this->status, ['delivered', 'cancelled']);
    }

    // Obtine adresa de livrare formatata
    public function getFormattedShippingAddress()
    {
        $address = $this->shipping_address;
        return $address['street'] . ', ' . $address['city'] . ', ' . $address['postal_code'];
    }

    // Obtine adresa de facturare formatata
    public function getFormattedBillingAddress()
    {
        $address = $this->billing_address;
        return $address['street'] . ', ' . $address['city'] . ', ' . $address['postal_code'];
    }

    // Metoda pentru a obtine toate comenzile unui user
    public static function getUserOrders($userId)
    {
        return self::forUser($userId)->orderBy('ordered_at', 'desc')->get();
    }

    // Metoda pentru a obtine comenzile recente
    public static function getRecentOrders()
    {
        return self::recent()->orderBy('ordered_at', 'desc')->get();
    }

    // Metoda pentru a obtine comenzile cu un anumit status
    public static function getOrdersByStatus($status)
    {
        return self::withStatus($status)->orderBy('ordered_at', 'desc')->get();
    }

    // Accessor pentru statusul formatat
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'pending' => 'In asteptare',
            'confirmed' => 'Confirmata',
            'shipped' => 'Expedita',
            'delivered' => 'Livrata',
            'cancelled' => 'Anulata'
        ];

        return $statusLabels[$this->status] ?? 'Necunoscut';
    }

    // Metoda pentru a obtine timpul scurs de la comanda
    public function getTimeAgoAttribute()
    {
        return $this->ordered_at->diffForHumans();
    }

    // Metoda toString pentru afisare
    public function __toString()
    {
        return $this->order_number;
    }
}
