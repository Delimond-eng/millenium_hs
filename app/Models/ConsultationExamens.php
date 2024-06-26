<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationExamens extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consultation_examens';

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
        "code",
        "examen_id",
        "agent_id",
        "consult_id",
        "patient_id",
        "hopital_emplacement_id",
        "hopital_id",
        "created_by"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'consult_examen_create_At'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "id"=>"int",
        "examen_id"=>"int",
        "agent_id"=>"int",
        "consult_id"=>"int",
        "hopital_id"=>"int",
        "hopital_emplacement_id"=>"int",
        "consult_examen_create_At"=>"timestamp"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation pour lier à un examen
     * @return BelongsTo
    */
    public function examen():BelongsTo
    {
        return $this->belongsTo(ExamenLabo::class, foreignKey: 'examen_id');
    }

    /**
     * Relation pour lier à un médecin
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agents::class, foreignKey: 'agent_id');
    }

    /**
     * Relation pour lier à une consultation
     * @return BelongsTo
     */
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultations::class, foreignKey: 'consult_id');
    }

    /**
     * Relation pour lier à un emplacement
     * @return BelongsTo
     */
    public function emplacement(): BelongsTo
    {
        return  $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    public function patient():BelongsTo{
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }
}
