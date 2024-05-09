<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacieClient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pharmacie_clients';

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
        'client_nom',
        'client_phone',
        'pharmacie_id',
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
        'client_created_At' => 'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'client_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relation pour relier à une pharmacie
     * @return BelongsTo
     */
    public  function pharmacie():BelongsTo{
        return $this->belongsTo(Pharmacie::class, foreignKey: 'pharmacie_id');
    }

    /**
     * Relation pour relier à un produit
     * @return BelongsTo
     */
    public  function user():BelongsTo{
        return $this->belongsTo(User::class, foreignKey: 'created_by');
    }
}
