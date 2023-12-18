<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Echographie extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'echographies';

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
        'echographie_resultats',
        'suivi_grossesse_id',
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
        'echographie_create_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier à un patient
     * @return BelongsTo
     */
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patients::class, 'patient_id');
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
