<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationPediatrique extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'consultation_pediatriques';

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
        'poids_bebe',
        'taille_bebe',
        'tension_art_bebe',
        'temperature_bebe',
        'bebe_id',
        'hopital_id',
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
        'consult_pediatrique_created_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier le bebe à une consultation
    */
    public function bebe():BelongsTo
    {
        return $this->belongsTo(Naissance::class, 'bebe_id');
    }
}
