<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stocks';

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
        'stock_qte',
        'stock_date_exp',
        'stock_pa',
        'stock_pa_devise',
        'stock_obs',
        'produit_id',
        'fournisseur_id',
        'pharmacie_id',
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
        'stock_created_At'=>'datetime:d-m-Y H:i:s',
        'stock_date_exp'=>'date:d-m-Y'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation pour lier à un fournisseur
     * @return BelongsTo
     */
    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }


    /**
     * Relation pour lier à un fournisseur
     * @return BelongsTo
     */
    public function fournisseur():BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }




    /**
     * Relation pour lier à une pharmacie
     * @return BelongsTo
     */
    public function pharmacie():BelongsTo
    {
        return $this->belongsTo(Pharmacie::class, 'pharmacie_id');
    }


    /**
     * Relation pour lier à un utilisateur
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
