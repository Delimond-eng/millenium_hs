<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartenerAgent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partener_agents';

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
        'agent_matricule',
        'agent_num_convention',
        'agent_nom',
        'agent_prenom',
        'agent_sexe',
        'agent_etat_civil',
        'agent_nbre_efts',
        'partener_id',
        'hopital_id',
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
        'agent_created_At'=>'datetime:d/m/Y'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'agent_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation directly to Hospital
     * @return BelongsTo
     */
    public function hopital():BelongsTo{
        return $this->belongsTo(Hopital::class, 'hopital_id');
    }


    /**
     * Relation directly Partener
     * @return BelongsTo
     */
    public function partener():BelongsTo{
        return $this->belongsTo(Partener::class, 'partener_id');
    }


    /**
     * Relation directly to Hospital
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
}
