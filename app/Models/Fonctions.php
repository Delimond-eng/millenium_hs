<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
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
    use HasApiTokens, HasFactory, Notifiable;
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
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fonction_libelle',
        'created_by',
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
       'id' => 'int', 'fonction_libelle' => 'string', 'created_by'=>'int', 'fonction_create_At' => 'timestamp', 'fonction_status' => 'string'
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

    /**
     * Summary of agent
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agent():HasMany{
        return $this->hasMany(Agents::class);
    }
}