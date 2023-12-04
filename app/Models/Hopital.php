<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hopital extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hopitals';

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

    protected $fillable = ["hopital_nom","hopital_adresse", "hopital_logo"];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'hopital_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function emplacements():HasMany{
        return $this->hasMany(HopitalEmplacement::class, foreignKey: 'hopital_id', localKey: $this->primaryKey);
    }
}
