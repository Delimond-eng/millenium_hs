<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientTraitement extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_traitements';

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
        'traitement_obs',
        'traitement_status',
        'prescription_id',
        'suivi_id',
        'patient_id',
        'agent_id',
        'hopital_id',
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation to suvi
     * @return BelongsTo
     */
    public  function suivi():BelongsTo{
        return $this->belongsTo(PatientSuivi::class, foreignKey: 'suivi_id');
    }

    /**
     * Relation to patient
     * @return BelongsTo
     */
    public  function patient():BelongsTo{
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }

    /**
     * Relation to prescription
     * @return BelongsTo
     */
    public  function prescription():BelongsTo{
        return $this->belongsTo(Prescriptions::class, foreignKey: 'prescription_id');
    }

    /**
     * Relation to agent
     * @return BelongsTo
     */
    public  function agent():BelongsTo{
        return $this->belongsTo(Agents::class, foreignKey: 'agent_id');
    }

    /**
     * Relation directly to Hospital
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation to emplacement
     * @return BelongsTo
     */

    public  function emplacement():BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    /**
     * Relation directly to Hospital
     * @return BelongsTo
     */
    public function hopital():BelongsTo{
        return $this->belongsTo(Hopital::class, 'hopital_id');
    }
}
