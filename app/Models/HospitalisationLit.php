<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalisationLit extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hospitalisation_lits';

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
        'lit_numero',
        'lit_status',
        'type_id',
        'service_id',
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
        'lit_create_At'=>'date:d-m-Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'lit_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relier à un service concerné
     * @return BelongsTo
     */
    public function service():BelongsTo
    {
        return $this->belongsTo(Services::class, foreignKey: 'service_id');
    }

    /**
     * Relier à un type de lit
     * @return BelongsTo
     */
    public function type():BelongsTo
    {
        return $this->belongsTo(LitType::class, foreignKey: 'type_id');
    }

    /**
     * Relier à un emplacement de l'hopital
     * @return BelongsTo
     */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    /**
     * Relier à un utilisateur connecté ayant  créé l'hospitalisation
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'created_by');
    }
}
