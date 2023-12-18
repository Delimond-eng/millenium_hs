<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accouchement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accouchements';

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
        'accouchement_type',
        'accouchement_nbre_bebe',
        'accouchement_date_heure',
        'patient_id',
        'hopital_id',
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
        'accouchement_date_heure'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier le patient(mère) à un accouchement
    */
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }

    /**
     * Relation pour lier à un emplacement
     * @return BelongsTo
     */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, 'hopital_emplacement_id');
    }
}
