<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturationConfig extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facturation_configs';

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
        'facturation_config_libelle',
        'facturation_config_montant',
        'facturation_config_montant_devise',
        'created_by',
        'hopital_emplacement_id',
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
        'facturation_config_created_At'=>'datetime:d/m/Y'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'facturation_config_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relier directement à un emplacement de l'hosto
     * @author Gaston delimond
     * @time 16/01/2024 14:24
     * @return BelongsTo
    */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    /**
     * user session action
     * @return  BelongsTo
    */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'created_by');
    }
}
