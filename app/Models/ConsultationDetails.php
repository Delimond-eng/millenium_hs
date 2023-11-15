<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $consult_detail_id
 * @property int    $consult_detail_create_At
 * @property int    $consult_id
 * @property string $consult_detail_libelle
 * @property string $consult_detail_valeur
 * @property string $consult_detail_obs
 * @property string $consult_detail_status
 */
class ConsultationDetails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consultation_details';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'consult_detail_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consult_detail_libelle', 'consult_detail_valeur', 'consult_detail_obs', 'consult_detail_create_At', 'consult_detail_status', 'consult_id'
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
        'consult_detail_id' => 'int', 'consult_detail_libelle' => 'string', 'consult_detail_valeur' => 'string', 'consult_detail_obs' => 'string', 'consult_detail_create_At' => 'timestamp', 'consult_detail_status' => 'string', 'consult_id' => 'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'consult_detail_create_At'
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
