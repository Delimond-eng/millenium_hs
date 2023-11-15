<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    $agent_id
 * @property int    $adresse_id
 * @property int    $agence_affectation_id
 * @property int    $nbre_enfant
 * @property int    $agent_service_id
 * @property int    $agent_grade_id
 * @property int    $agent_fontion_id
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
    protected $primaryKey = 'agent_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'postnom', 'prenom', 'matricule', 'nationalite', 'date_naissance', 'adresse_id', 'sexe', 'etat_civil', 'date_engagement', 'agence_affectation_id', 'nbre_enfant', 'agent_status', 'date_enregistrement', 'agent_matricule', 'agent_nom', 'agent_prenom', 'agent_sexe', 'agent_telephone', 'agent_service_id', 'agent_grade_id', 'agent_fontion_id', 'agent_create_At', 'agent_status'
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
        'agent_id' => 'int', 'nom' => 'string', 'postnom' => 'string', 'prenom' => 'string', 'matricule' => 'string', 'nationalite' => 'string', 'adresse_id' => 'int', 'sexe' => 'string', 'etat_civil' => 'string', 'agence_affectation_id' => 'int', 'nbre_enfant' => 'int', 'agent_status' => 'string', 'agent_matricule' => 'string', 'agent_nom' => 'string', 'agent_prenom' => 'string', 'agent_telephone' => 'string', 'agent_service_id' => 'int', 'agent_grade_id' => 'int', 'agent_fontion_id' => 'int', 'agent_create_At' => 'timestamp'
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
    public function grade(): HasOne{
        return $this->hasOne(Grades::class, 'agent_grade_id', $this->primaryKey);
    }
}
