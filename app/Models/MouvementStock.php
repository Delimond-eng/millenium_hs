<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fournisseurs';

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
        'mouvement_stock_type',
        'mouvement_stock_qte',
        'mouvement_stock_bon_code',
        'produit_id',
        'stock_id',
        'hopital_id',
        'hopital_emplacement_id',
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
        'mouvement_stock_created_At'=>'datetime:d-m-Y H:i:s'
    ];
}
