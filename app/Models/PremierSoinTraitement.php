<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PremierSoinTraitement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'premier_soin_traitements';

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
        'ps_traitement_libelle',
        'ps_traitement_type',
        'ps_traitement_dosage',
        'ps_traitement_unite',
        'premier_soin_id'
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
        'ps_traitement_created_At'=>'datetime:d/m/Y'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'ps_traitement_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation directly to Premier Soin
     * @return BelongsTo
     */
    public function premier_soin():BelongsTo{
        return $this->belongsTo(PremierSoin::class, 'premier_soin_id');
    }
}
