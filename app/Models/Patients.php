<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $patient_code
 * @property string $patient_nom
 * @property string $patient_prenom
 * @property string $patient_adresse
 * @property string $patient_telephone
 * @property string $patient_status
 * @property float  $patient_poids
 * @property float  $patient_temperature
 * @property int    $patient_age
 * @property int    $patient_create_At
 */
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
        'patient_code', 'patient_nom', 'patient_prenom', 'patient_sexe', 'patient_poids', 'patient_temperature', 'patient_age', 'patient_adresse', 'patient_telephone', 'patient_taille', 'patient_create_At', 'patient_status', 'agent_id'
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
        'patient_code' => 'string', 'patient_nom' => 'string', 'patient_prenom' => 'string', 'patient_poids' => 'double', 'patient_temperature' => 'double', 'patient_age' => 'int', 'patient_adresse' => 'string', 'patient_telephone' => 'string', 'patient_create_At' => 'timestamp', 'patient_status' => 'string'
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

    public function agent(): BelongsTo{
        return $this->belongsTo(Agents::class);
    }
}
