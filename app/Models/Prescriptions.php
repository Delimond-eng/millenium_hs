<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $proscription_traitement
 * @property string $prescription_posologie
 * @property string $prescription_traitement_type
 * @property string $prescription_status
 * @property int    $prescription_create_At
 * @property int    $consult_id
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
        'prescription_traitement','prescription_posologie', 'prescription_traitement_type', 'consult_id',
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
        'prescription_traitement' => 'string', 'prescription_posologie' => 'string', 'prescription_traitement_type' => 'string', 'prescription_create_At' => 'timestamp', 'prescription_status' => 'string'
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
     * Summary of consultations
     * @return BelongsTo
    */
    public function consultation(): BelongsTo{
        return $this->belongsTo(Consultations::class, foreignKey: 'consult_id');
    }

}
