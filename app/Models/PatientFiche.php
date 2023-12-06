<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientFiche extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_fiches';

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
        "patient_fiche_poids",
        "patient_fiche_taille",
        "patient_fiche_taille_unite",
        "patient_fiche_temperature",
        "patient_fiche_temperature_unite",
        "patient_fiche_tension_art",
        "patient_fiche_tension_art_unite",
        "patient_fiche_freq_cardio",
        "patient_fiche_freq_cardio_unite",
        "patient_fiche_age",
        "patient_id",
        'hopital_id',
        'hopital_emplacement_id'
    ];

    /**
     * Summary of patient
     * @return BelongsTo
     */


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'patient_detail_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    public function patient(): BelongsTo{
        return $this->belongsTo(Patients::class, foreignKey:"patient_id");
    }
}
