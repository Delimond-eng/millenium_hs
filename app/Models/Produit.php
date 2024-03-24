<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'produit_stock_min',
        'produit_description',
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
        'produit_created_At'=>'datetime:d-m-Y H:i:s'
    ];


    /**
     * hopital
     * @return BelongsTo
    */
    public function hopital():BelongsTo
    {
       return $this->belongsTo(Hopital::class, foreignKey: 'hopital_id');
    }


    /**
     * categorie
     * @return BelongsTo
    */
    public function categorie():BelongsTo
    {
       return $this->belongsTo(ProduitCategorie::class, foreignKey: 'categorie_id');
    }

    /**
     * unite
     * @return BelongsTo
    */
    public function unite(): BelongsTo
    {
        return $this->belongsTo(ProduitUnite::class, foreignKey: 'unite_id');
    }

    /**
     * Type
     * @return BelongsTo
    */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProduitType::class, foreignKey: 'type_id');
    }


    /**
     * stocks
     * @return HasMany
    */
    public function stocks():HasMany
    {
        return $this->hasMany(Stock::class, foreignKey: 'produit_id', localKey: 'id');
    }
}

