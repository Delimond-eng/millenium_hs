<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuiviPostNatale extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suivi_post_natales';

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
        'suivi_post_natale_etat_sante',
        'suivi_post_natale_recommandations',
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
        'suivi_post_natale_created_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier à un patient
     * @return BelongsTo
    */
    public function patient():BelongsTo
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
}
