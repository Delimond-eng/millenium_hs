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
        'fournisseur_create_At'=>'datetime:d-m-Y H:i:s'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation pour lier à un hopital
     * @return BelongsTo
     */
    public function hopital():BelongsTo
    {
        return $this->belongsTo(Hopital::class, 'hopital_id');
    }
}
