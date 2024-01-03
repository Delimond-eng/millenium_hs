<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitePrenatale extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visite_prenatales';

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
        'suivi_grossesse_id',
        'visite_poids',
        'visite_tension_art',
        'visite_recommandations',
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
        'visite_created_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier à un suivi
     * @return BelongsTo
    */
    public function suivi():BelongsTo
    {
        return $this->belongsTo(SuiviGrossesse::class, 'suivi_grossesse_id');
    }


}
