<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Specifica numele tabelei (optional, Laravel il deduce automat)
    protected $table = 'categories';

    // Campurile care pot fi completate in masa (mass assignment)
    protected $fillable = [
        'name',
        'description'
    ];

    // Campurile care sunt protejate si nu pot fi completate in masa
    protected $guarded = [
        'id'
    ];

    // Specifica tipurile de date pentru campuri (casting)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Reguli de validare simple (optional, de obicei se pun in Request)
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ];
    }

    // Metoda pentru a obtine toate categoriile ordonate alfabetic
    public static function getAllOrdered()
    {
        return self::orderBy('name', 'asc')->get();
    }

    // Metoda pentru a cauta o categorie dupa nume
    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    // Accessor - modifica cum se afiseaza numele (primul caracter cu majuscula)
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    // Mutator - modifica cum se salveaza numele (cu litere mici)
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower(trim($value));
    }

    // Scope pentru a filtra categoriile care au descriere
    public function scopeWithDescription($query)
    {
        return $query->whereNotNull('description');
    }

    // Scope pentru a cauta dupa nume (partial match)
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    // Relatia cu alte modele (exemplu: o categorie poate avea mai multe produse)
    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // Metoda pentru a obtine numarul de produse din categoria (daca exista relatia)
    // public function getProductsCountAttribute()
    // {
    //     return $this->products()->count();
    // }

    // Metoda toString pentru afisare usoara
    public function __toString()
    {
        return $this->name;
    }
}
