<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fournisseur extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fournisseurs';

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
        'fournisseur_nom',
        'fournisseur_adresse',
        'fournisseur_email',
        'fournisseur_telephone',
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
        'fournisseur_create_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Relation pour lier à un emplacement
     * @return BelongsTo
     */
    public function emplacement():BelongsTo
    {
        return $this->belongsTo(HopitalEmplacement::class, 'hopital_emplacement_id');
    }
}
