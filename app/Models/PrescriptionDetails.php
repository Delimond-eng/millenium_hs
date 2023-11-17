<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $prescription_detail_libelle
 * @property string $prescription_detail_valeur
 * @property string $prescrption_detail_obs
 * @property string $prescription_detail_status
 * @property int    $prescription_detail_create_At
 */
class PrescriptionDetails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prescription_details';

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
        'prescription_detail_libelle', 'prescription_detail_valeur', 'prescrption_detail_obs', 'prescription_detail_create_At', 'prescription_detail_status', 'prescription_id'
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
        'prescription_detail_libelle' => 'string', 'prescription_detail_valeur' => 'string', 'prescrption_detail_obs' => 'string', 'prescription_detail_create_At' => 'timestamp', 'prescription_detail_status' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'prescription_detail_create_At'
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
