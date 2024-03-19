<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produits';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'produit_libelle',
        'produit_code',
        'produit_prix_unitaire',
        'produit_stock_min',
        'categorie_id',
        'unite_id',
        'type_id',
        'hopital_id',
        'created_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'produit_created_At'=>'datetime:d-m-Y H:i:s'
    ];
}
