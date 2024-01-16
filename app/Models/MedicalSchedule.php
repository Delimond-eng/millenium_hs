<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalSchedule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medical_schedules';

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
        'schedule_date_heure',
        'schedule_duree',
        'schedule_note',
        'agent_id',
        'patient_id',
        'hopital_emplacement_id',
        'created_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'schedule_created_At'=>'datetime:d/m/Y H:i',
        'schedule_date_heure'=>'datetime:d/m/Y H:i',
    ];


    public function agent():BelongsTo
    {
        return $this->belongsTo(Agents::class, foreignKey: 'agent_id');
    }

    public function patient():BelongsTo
    {
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }
}
