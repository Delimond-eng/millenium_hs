<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacistSession extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pharmacist_sessions';


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
        'initial_balance',
        'closing_balance',
        'nbre_ticket',
        'user_id',
        'pharmacie_id',
        'started_at',
        'end_at',
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
        'created_at' => 'date:d/m/Y H:i',
        'updated_at' => 'date:d/m/Y H:i',
    ];


    /**
     * Relation directly to User
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation to pharmacie
     * @return BelongsTo
     */
    public function pharmacie():BelongsTo{
        return $this->belongsTo(Pharmacie::class, 'pharmacie_id');
    }
}
