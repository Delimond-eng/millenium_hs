<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $fonction_id
 * @property int    $fonction_id
 * @property int    $biotime_fonction_id
 * @property int    $user_id
 * @property int    $fonction_create_At
 * @property string $libelle
 * @property string $fonction_statut
 * @property string $fonction_libelle
 * @property string $fonction_status
 */
class Fonctions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fonctions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'fonction_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'biotime_fonction_id', 'user_id', 'libelle', 'fonction_statut', 'date_enregisrrement', 'fonction_libelle', 'fonction_create_At', 'fonction_status'
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
        'fonction_id' => 'int', 'fonction_id' => 'int', 'biotime_fonction_id' => 'int', 'user_id' => 'int', 'libelle' => 'string', 'fonction_statut' => 'string', 'fonction_libelle' => 'string', 'fonction_create_At' => 'timestamp', 'fonction_status' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fonction_create_At'
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
