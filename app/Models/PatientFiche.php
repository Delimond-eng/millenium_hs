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
    protected $table = 'patient_details';

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
        "patient_detail_poids",
        "patient_detail_taille",
        "patient_detail_temperature",
        "patient_tension_art",
        "patient_detail_age",
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
