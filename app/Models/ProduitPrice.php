<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProduitPrice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produit_prices';

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
        'produit_prix',
        'produit_prix_devise',
        'pharmacie_id',
        'produit_id',
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
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'produit_prix_create_At'=>'datetime:d-m-Y H:i:s'
    ];


    /**
     * Relation pour lier à un hopital
     * @return BelongsTo
     */
    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class, foreignKey: 'produit_id');
    }


    /**
     * Relation pour lier à une pharmacie
     * @return BelongsTo
     */
    public function pharmacie():BelongsTo
    {
        return $this->belongsTo(Pharmacie::class, foreignKey: 'pharmacie_id');
    }
}
