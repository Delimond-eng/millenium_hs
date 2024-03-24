<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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
        "prescription_traitement_freq",
        "prescription_traitement_duree",
        "prescription_traitement_posologie",
        "produit_id",
        "consult_id",
        'hopital_emplacement_id',
        'created_by',
    ];

    /**
     * The attributes excluded from the model's JSON form.
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
         'prescription_create_At' => 'date:d/m/Y H:i',
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

    /**
     * Summary of consultations
     * @return BelongsTo
    */
    public function consultation(): BelongsTo{
        return $this->belongsTo(Consultations::class, foreignKey: 'consult_id', relation: 'id');
    }

    /**
     * Summary of product
     * @return BelongsTo
     */
    public function produit(): BelongsTo{
        return $this->belongsTo(Produit::class, foreignKey: 'produit_id', relation: 'id');
    }

}
