<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientSignesVitaux extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_signes_vitaux';

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
        "patient_sv_poids",
        "patient_sv_poids_unite",
        "patient_sv_taille",
        "patient_sv_taille_unite",
        "patient_sv_temperature",
        "patient_sv_temperature_unite",
        "patient_sv_tension_art",
        "patient_sv_tension_art_unite",
        "patient_sv_freq_cardio",
        "patient_sv_freq_cardio_unite",
        "patient_sv_saturation",
        "patient_sv_saturation_unite",
        "patient_sv_age",
        "patient_id",
        "consult_id",
        'hopital_id',
        'hopital_emplacement_id',
        'created_by'
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
        'patient_sv_created_At'
    ];


    /**
     * The attributes that should be mutated to casts
     *
     * @var $casts
     */
    protected $casts = [
        'patient_sv_created_At' => 'date:d/m/Y H:i'
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
