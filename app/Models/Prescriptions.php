<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $prescreption_id
 * @property int    $prescription_create_At
 * @property string $prescription_libelle
 * @property string $prescrption_status
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
    protected $primaryKey = 'prescreption_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prescription_libelle', 'prescription_create_At', 'prescrption_status'
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
        'prescreption_id' => 'int', 'prescription_libelle' => 'string', 'prescription_create_At' => 'timestamp', 'prescrption_status' => 'string'
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
}
