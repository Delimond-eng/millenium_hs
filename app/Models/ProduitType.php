<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProduitType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produit_types';

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
        'type_libelle',
        'type_description',
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
        'type_created_At'=>'datetime:d-m-Y H:i:s'
    ];


    /**
     * Relation pour voir la liste des produits appartenants à une categorie
     * @return HasMany
     */
    public function produits():HasMany
    {
        return $this->hasMany(Produit::class, foreignKey: 'type_id', localKey: 'id');
    }

    /**
     * Relation pour lier à un hopital
     * @return BelongsTo
     */
    public function hopital():BelongsTo
    {
        return $this->belongsTo(Hopital::class, foreignKey: 'hopital_id');
    }
}
