<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'agent_create_At'=>'datetime:d/m/Y H:i'
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
     * Relation To user
     * @return HasOne
     */
    public function user():HasOne{
        return $this->hasOne(User::class, foreignKey: 'agent_id', localKey: 'id');
    }

    /**
     * Voir l'emplacement de l'agent
     * @return BelongsTo
    */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }
}
