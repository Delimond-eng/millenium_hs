<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Hospitalisation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hospitalisations';

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
        'hospitalisation_start_At',
        'hospitalisation_end_At',
        'hospitalisation_raison_admission',
        'patient_id',
        'lit_id',
        'service_responsable_id',
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
        'hospitalisation_start_At'=>'date:d/m/Y H:i',
        'hospitalisation_end_At'=>'date:d/m/Y H:i',
        'hospitalisation_created_At'=>'date:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'hospitalisation_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Summary of agent
     * @return BelongsTo
     */
    public function agent():BelongsTo{
        return $this->belongsTo(Agents::class, foreignKey: 'service_responsable_id');
    }

    /**
     * Relier à un agent
     * @return BelongsTo
    */
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patients::class, foreignKey: 'patient_id');
    }


    /**
     * Relier à un lit
     * @return BelongsTo
    */
    public function lit():BelongsTo
    {
        return $this->belongsTo(HospitalisationLit::class, foreignKey: 'lit_id');
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
