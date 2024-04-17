<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacieOperation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pharmacie_operations';

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
        'operation_qte',
        'operation_status',
        'operation_libelle',
        'operation_obs',
        'pharmacie_id',
        'pharmacie_dest_id',
        'fournisseur_id',
        'produit_id',
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
        'operation_created_At' => 'datetime:d/m/Y H:i'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'operation_created_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Relation pour relier à un produit
     * @return BelongsTo
     */
    public  function produit():BelongsTo{
        return $this->belongsTo(Produit::class, foreignKey: 'produit_id');
    }

    /**
     * Relation pour relier à une pharmacie
     * @return BelongsTo
     */
    public  function pharmacie():BelongsTo{
        return $this->belongsTo(Pharmacie::class, foreignKey: 'pharmacie_id');
    }


    /**
     * Relation pour relier à une pharmacie de destination
     * @return BelongsTo
     */
    public  function pharmacie_destination():BelongsTo{
        return $this->belongsTo(Pharmacie::class, foreignKey: 'pharmacie_dest_id');
    }

    /**
     * Relation pour relier à un produit
     * @return BelongsTo
     */
    public  function fournisseur():BelongsTo{
        return $this->belongsTo(Fournisseur::class, foreignKey: 'fournisseur_id');
    }

    /**
     * Relation pour relier à un produit
     * @return BelongsTo
     */
    public  function user():BelongsTo{
        return $this->belongsTo(User::class, foreignKey: 'created_by');
    }

}
