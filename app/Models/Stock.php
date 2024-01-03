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
        'stock_qte_dispo',
        'stock_qte_min',
        'medicament_id',
        'fournisseur_id',
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
        'fournisseur_created_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier à un fournisseur
     * @return BelongsTo
     */
    public function fournisseur():BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
