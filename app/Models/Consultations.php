<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $consut_id
 * @property int    $consult_agent_id
 * @property int    $consult_patient_id
 * @property int    $consult_create_At
 * @property string $consult_libelle
 * @property string $consult_obs
 * @property string $consult_status
 */
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
    protected $primaryKey = 'consut_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consult_libelle', 'consult_obs', 'consult_agent_id', 'consult_patient_id', 'consult_create_At', 'consult_status'
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
        'consut_id' => 'int', 'consult_libelle' => 'string', 'consult_obs' => 'string', 'consult_agent_id' => 'int', 'consult_patient_id' => 'int', 'consult_create_At' => 'timestamp', 'consult_status' => 'string'
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
}
