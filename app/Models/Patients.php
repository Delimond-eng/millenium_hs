<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patients extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patients';

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
        'patient_code',
        'patient_code_appel',
        'patient_nom',
        'patient_prenom',
        'patient_sexe',
        'patient_adresse',
        'patient_telephone',
        'patient_contact_urgence',
        'patient_datenais',
        'patient_etat_civil',
        'patient_gs',
        'patient_num_assurance',
        'patient_create_At',
        'patient_status',
        'created_by',
        'hopital_id',
        'hopital_emplacement_id'
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
        'patient_create_At' => 'date:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'patient_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...


    /**
     * Summary of agent
     * @return BelongsTo
     */
    public function agent(): BelongsTo{
        return $this->belongsTo(Agents::class, foreignKey:'created_by');
    }

    /**
     * Summary of prescriptions
     * @return HasMany
     */
    public function prescriptions():HasMany{
        return $this->hasMany(Prescriptions::class);
    }


    /**
     * Relation To Patient detail
     * @return HasMany
    */
    public function details(): HasMany{
        return $this->hasMany(PatientFiche::class, foreignKey: 'patient_id', localKey: 'id');
    }


    /**
     * Relation pour voir les consultations du patient
    */
    public function consultations():HasMany
    {
        return $this->hasMany(Consultations::class, foreignKey: 'patient_id', localKey: 'id');
    }
}
