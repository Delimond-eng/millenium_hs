<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamenLabo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'examen_labos';

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
        "examen_labo_libelle",
        "examen_labo_prix",
        "examen_labo_prix_devise",
        "examen_labo_description",
        "created_by",
        "hopital_id",
        "hopital_emplacement_id",
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'examen_labo_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relation d'appartenance à un emplacement spécifique
     * @return BelongsTo
     */
    public function emplacement(): BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }
}
