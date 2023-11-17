<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    $agent_id
 * @property int    $adresse_id
 * @property int    $agence_affectation_id
 * @property int    $nbre_enfant
 * @property int    $agent_create_At
 * @property string $nom
 * @property string $postnom
 * @property string $prenom
 * @property string $matricule
 * @property string $nationalite
 * @property string $sexe
 * @property string $etat_civil
 * @property string $agent_status
 * @property string $agent_matricule
 * @property string $agent_nom
 * @property string $agent_prenom
 * @property string $agent_telephone
 * @property string $agent_adresse
 * @property string $agent_status
 */
class Agents extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agents';

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
         'agent_matricule', 'agent_nom', 'agent_prenom', 'agent_sexe', 'agent_telephone', 'agent_adresse', 'grade_id', 'service_id', 'fonction_id'
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
        'id' => 'int', 'agent_matricule' => 'string', 'agent_nom' => 'string', 'agent_prenom' => 'string', 'agent_telephone' => 'string', 'agent_adresse' => 'string', 'agent_create_At' => 'timestamp', 'agent_status' => 'string', 'grade_id'=>'int', 'service_id'=>'int', 'fonction_id'=>'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'agent_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grades::class);
    }
    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonctions::class);
    }
    public function service(): BelongsTo{
        return $this->belongsTo(Services::class);
    }
    public function patients(): HasMany{
        return $this->hasMany(Patients::class);
    }
}
