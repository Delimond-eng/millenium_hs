<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medicaments';

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
        'medicament_libelle',
        'medicament_code',
        'medicament_prix_unitaire',
        'medicament_date_exp',
        'medicament_stock_min',
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
        'medicament_created_At'=>'datetime:d-m-Y H:i:s'
    ];
}
