<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalisationTransfert extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hospitalisation_transferts';

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
        'hospitalisation_id',
        'lit_origine_id',
        'lit_destination_id',
        'transfert_date_heure',
        'transfert_raison',
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
        'transfert_created_At'=>'date:d-m-Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'transfert_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relier à un hospitalisation
     * @return BelongsTo
     */
    public function hospitalisation():BelongsTo
    {
        return $this->belongsTo(Hospitalisation::class, foreignKey: 'hospitalisation_id');
    }


    /**
     * Relier à un lit de provenance
     * @return BelongsTo
     */
    public function origine():BelongsTo
    {
        return $this->belongsTo(HospitalisationLit::class, foreignKey: 'lit_origine_id');
    }

    /**
     * Relier à un lit de provenance
     * @return BelongsTo
     */
    public function destination():BelongsTo
    {
        return $this->belongsTo(HospitalisationLit::class, foreignKey: 'lit_destination_id');
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
