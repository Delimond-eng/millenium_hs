<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PremierSoin extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'premier_soins';

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
        'premier_soin_date_heure',
        'premier_soin_motif',
        'premier_soin_obs',
        'patient_id',
        'agent_id',
        'created_by',
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
        'premier_soin_created_At'=>'date:d/m/Y',
        'premier_soin_date_heure'=>'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'premier_soin_created_At',
        'premier_soin_date_heure',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relation To list all traitements
     * @return HasMany
     */
    public function traitements():HasMany{
        return $this->hasMany(PremierSoinTraitement::class, foreignKey: 'premier_soin_id', localKey: 'id');
    }

    /**
     * Relation directly to Hopital Emplacement
     * @return BelongsTo
     */
    public function emplacement():BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, 'hopital_emplacement_id');
    }

    /**
     * Relation directly to Patient
     * @return BelongsTo
     */
    public function agent():BelongsTo{
        return $this->belongsTo(Agents::class, 'agent_id');
    }


    /**
     * Relation directly to User
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Relation directly to Agent
     * @return BelongsTo
     */
    public function patient():BelongsTo{
        return $this->belongsTo(Patients::class, 'patient_id');
    }
}
