<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LitType extends Model
{
    /**
 * The database table used by the model.
 *
 * @var string
 */
    protected $table = 'lit_types';

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
        'type_libelle',
        'type_description',
        'hopital_emplacement_id',
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
        'type_created_At'=>'date:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'type_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relier à un emplacement de l'hopital
     * @return BelongsTo
     */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, foreignKey: 'hopital_emplacement_id');
    }

    /**
     * Relier à un utilisateur connecté ayant  créé l'hospitalisation
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'created_by');
    }
}
