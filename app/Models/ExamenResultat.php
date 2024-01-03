<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamenResultat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'examen_resultats';

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
        'examen_resultat_libelle',
        'examen_resultat_description',
        'examen_resultat_media',
        'examen_id',
        'echantillon_id',
        'labo_id',
        'suivi_id',
        'patient_id',
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
        'examen_resultat_created_At'=>'datetime:d-m-Y H:i:s'
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

    /**
     * Relation pour lier à un examen labo
     * @return BelongsTo
     */
    public function examen():BelongsTo
    {
        return $this->belongsTo(ExamenLabo::class, 'examen_id');
    }

    /**
     * Relation pour lier à un echantillon du test
     * @return BelongsTo
     */
    public function echantillon():BelongsTo
    {
        return $this->belongsTo(ExamenEchantillon::class, 'echantillon_id');
    }
}
