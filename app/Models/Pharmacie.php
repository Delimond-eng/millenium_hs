<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pharmacie extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pharmacies';

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
        'pharmacie_nom',
        'pharmacie_telephone',
        'pharmacie_adresse',
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
        'id' => 'int',
        'pharmacie_nom' => 'string',
        'pharmacie_adresse' => 'string',
        'pharmacie_telephone' => 'string',
        'hopital_id' => 'int',
        'hopital_emplacement_id' => 'int',
        'pharmacie_create_At' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'pharmacie_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relation to emplacement
     * @return BelongsTo
    */

    public  function emplacement():BelongsTo{
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    /**
     * Relation directly to Hospital
     * @return BelongsTo
    */
    public function hopital():BelongsTo{
        return $this->belongsTo(Hopital::class, 'hopital_id');
    }
}
