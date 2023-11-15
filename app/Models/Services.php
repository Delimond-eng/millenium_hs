<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $service_id
 * @property int    $service_id
 * @property int    $biotime_service_id
 * @property int    $service_create_At
 * @property string $user_id
 * @property string $nom
 * @property string $libelle
 * @property string $service_statut
 * @property string $date_enregistrement
 * @property string $service_libelle
 * @property string $service_status
 */
class Services extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'service_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'biotime_service_id', 'user_id', 'nom', 'libelle', 'service_statut', 'date_enregistrement', 'service_libelle', 'service_create_At', 'service_status'
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
        'service_id' => 'int', 'service_id' => 'int', 'biotime_service_id' => 'int', 'user_id' => 'string', 'nom' => 'string', 'libelle' => 'string', 'service_statut' => 'string', 'date_enregistrement' => 'string', 'service_libelle' => 'string', 'service_create_At' => 'timestamp', 'service_status' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'service_create_At'
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
