<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consultations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consultations';

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
        'consult_libelle',
        'consult_diagnostic',
        'consult_create_At',
        'consult_status',
        'patient_id',
        'agent_id',
        'hopital_id',
        'hopital_emplacement_id',
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'consult_create_At' => 'date:d/m/Y',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'consult_create_At'
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
        return $this->belongsTo(Agents::class, foreignKey: 'agent_id');
    }

    /**
     * Summary of patient
     * @return BelongsTo
     */
    public function patient(): BelongsTo{
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }

    /**
     * Voir les signes vitaux
     * @return HasOne
    */
    public function signe():HasOne
    {
        return $this->hasOne(PatientSignesVitaux::class, foreignKey: 'consult_id', localKey: 'id');
    }

    public function prescriptions(): HasMany{
        return $this->hasMany(Prescriptions::class, foreignKey: 'consult_id', localKey: 'id');
    }

    /**
     * Relation pour voir tous les détails d'une consultation
     * @return HasMany
    */
    public function antecedents():HasMany {
        return  $this->hasMany(ConsultationDetails::class, foreignKey: 'consult_id', localKey: 'id');
    }


    /**
     * Relation pour voir tous les symptomes liés à une consultation
    */
    public function symptomes() : HasMany{
        return $this->hasMany(ConsultationSymptomes::class, foreignKey: 'consult_id', localKey: 'id');
    }

    /**
     * Relation pour voir tous les examens à une consultation
     */
    public function examens():HasMany{
        return $this->hasMany(ConsultationExamens::class, foreignKey: 'consult_id', localKey: 'id');
    }
}
