<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturePaiement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facture_paiements';

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
        'paiement_montant',
        'paiement_montant_devise',
        'patient_id',
        'facturation_id',
        'created_by',
        'hopital_id',
        'hopital_emplacement_id'
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
        'paiement_created_At'=>'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'paiement_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation directly to Hospital emplacement
     * @return BelongsTo
     */
    public function emplacement():BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, 'hopital_emplacement_id');
    }

    /**
     * Relation directly to Hospital
     * @return BelongsTo
     */
    public function hopital():BelongsTo{
        return $this->belongsTo(Hopital::class, 'hopital_id');
    }

    /**
     * Relation Patient
     * @return BelongsTo
     */
    public function patient():BelongsTo{
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    /**
     * Relation User
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * Relation Facturation
     * @return BelongsTo
     */
    public function facturation():BelongsTo{
        return $this->belongsTo(FacturationConfig::class, 'facturation_id');
    }
}
