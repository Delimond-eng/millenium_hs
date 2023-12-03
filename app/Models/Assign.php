<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assign extends Model
{

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assigns';

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
        'assign_agent_id', 'assign_patient_id',
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
        'id' => 'int', 'assign_agent_id'=>'int', 'assign_patient'=>'int', 'assign_create_At'=> 'timestamp', 'hopital_id'=>'int', 'hopital_emplacement_id'=>'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'assign_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function agent():BelongsTo{
        return $this->belongsTo(Agents::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patients::class);
    }
}
