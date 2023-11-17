<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $consult_libelle
 * @property string $consult_obs
 * @property string $consult_status
 * @property int    $consult_create_At
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
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consult_libelle', 'consult_obs', 'consult_create_At', 'consult_status', 'patient_id', 'agent_id'
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
        'consult_libelle' => 'string', 'consult_obs' => 'string', 'consult_create_At' => 'timestamp', 'consult_status' => 'string'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent(): BelongsTo{
        return $this->belongsTo(Agents::class);
    }

    /**
     * Summary of patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo{
        return $this->belongsTo(Patients::class);
    }


}
