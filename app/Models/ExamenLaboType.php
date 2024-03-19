<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamenLaboType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'examen_labo_types';

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
        "type_libelle",
        "type_libelle_medical",
        "type_description",
        "examen_categorie_id",
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'type_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Voir tous les examens par type
     * @return HasMany
    */
    public function examens():HasMany
    {
        return $this->hasMany(ExamenLabo::class, foreignKey: 'type_id');
    }
}
