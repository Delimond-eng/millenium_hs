<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $prescription_libelle
 * @property string $prescrption_status
 * @property int    $prescription_create_At
 */
class Prescriptions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prescriptions';

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
        'prescription_libelle', 'prescription_create_At', 'prescrption_status', 'patient_id', 'agent_id'
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
        'prescription_libelle' => 'string', 'prescription_create_At' => 'timestamp', 'prescrption_status' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'prescription_create_At'
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

    /**
     * prescription details
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(PrescriptionDetails::class);
    }
}