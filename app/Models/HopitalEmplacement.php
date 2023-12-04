<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HopitalEmplacement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hopital_emplacements';

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
        "hopital_emplacement_libelle",
        "hopital_emplacement_adresse",
        "hopital_id"
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'hopital_emplacement_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    public function hopital():BelongsTo{
        return $this->belongsTo(Hopital::class, foreignKey: 'hopital_id');
    }
}
