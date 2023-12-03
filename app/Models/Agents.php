<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int    $agent_id
 * @property int    $adresse_id
 * @property int    $agence_affectation_id
 * @property int    $nbre_enfant
 * @property int    $agent_create_At
 * @property string $nom
 * @property string $postnom
 * @property string $prenom
 * @property string $matricule
 * @property string $nationalite
 * @property string $sexe
 * @property string $etat_civil
 * @property string $agent_status
 * @property string $agent_matricule
 * @property string $agent_nom
 * @property string $agent_prenom
 * @property string $agent_telephone
 * @property string $agent_adresse
 */
class Agents extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agents';

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
        'agent_matricule',
        'agent_nom',
        'agent_prenom',
        'agent_sexe',
        'agent_telephone',
        'agent_adresse',
        'agent_specialite',
        'agent_datenais',
        'grade_id',
        'service_id',
        'fonction_id',
        'user_id',
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
        'id' => 'int', 'agent_matricule' => 'string', 'agent_nom' => 'string', 'agent_prenom' => 'string', 'agent_telephone' => 'string', 'agent_datenais'=>'string', 'agent_specialite'=>'string', 'agent_adresse' => 'string', 'agent_create_At' => 'timestamp', 'agent_status' => 'string', 'grade_id'=>'int', 'service_id'=>'int', 'fonction_id'=>'int', 'created_id'=>'int', 'hopital_id'=>'int', 'hopital_emplacement_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'agent_create_At'
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
     * Summary of grade
     * @return BelongsTo
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grades::class);
    }

    /**
     * Summary of fonction
     * @return BelongsTo
     */
    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonctions::class);
    }

    /**
     * Summary of service
     * @return BelongsTo
     */
    public function service(): BelongsTo{
        return $this->belongsTo(Services::class);
    }

    /**
     * Summary of patients
     * @return HasMany
     */
    public function patients(): HasMany{
        return $this->hasMany(Patients::class, foreignKey: 'patient_id', localKey: 'id');
    }

    /**
     * Summary of prescriptions
     * @return HasMany
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescriptions::class);
    }

    /**
     * Summary of assignments
     * @return BelongsToMany
     */
    public function assignPatients() : BelongsToMany
    {
        return $this->belongsToMany(Patients::class, 'assigns', 'assign_agent_id', 'assign_patient_id');
    }

    /**
     * Summary of user
     * @return BelongsTo
     */
    public function user():HasOne{
        return $this->hasOne(User::class, localKey:'id');
    }
}
