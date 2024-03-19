<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamenLaboCategorie extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'examen_labo_categories';

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
        "categorie_libelle",
        "categorie_description",
        "labo_id",
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'categorie_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Voir les types pour chaque categorie
     * @return HasMany
    */
    public function types():HasMany
    {
        return $this->hasMany(ExamenLaboType::class, foreignKey: 'examen_categorie_id');
    }

    /**
     * Get Category*
     * @return BelongsTo
     */
    public function categorie():BelongsTo
    {
        return $this->belongsTo(ExamenLaboCategorie::class, foreignKey: 'examen_categorie_id');
    }


}
