<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Services extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
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
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_libelle',
        'service_description',
        'hopital_id',
        'hopital_emplacement_id',
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
        'id' => 'int',
        'service_libelle' => 'string',
        'service_description' => 'string',
        'created_by'=>'int',
        'service_create_At' => 'timestamp',
        'service_status' => 'string',
        'hopital_id'=>'int',
        'hopital_emplacement_id'=>'int',
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
    public function agents(): HasMany{
        return $this->hasMany(Agents::class);
    }

    /**
     * Relation d'appartenance à un emplacement spécifique
     * @return BelongsTo
    */
    public function emplacement(): BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }


}
