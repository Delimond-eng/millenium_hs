<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PharmacieTicket extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pharmacie_tickets';


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
        'ticket_code',
        'ticket_nb_items',
        'ticket_paiement',
        'ticket_devise',
        'client_id',
        'user_id',
        'pharmacie_id',
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
     * Get all items of ticket
     * @return HasMany
    */
    public function items(): HasMany
    {
        return $this->hasMany(PharmacieOperation::class, foreignKey: 'ticket_id', localKey: 'id');
    }


    /**
     * Relation directly to User
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation directly to Client
     * @return BelongsTo
     */
    public function client():BelongsTo{
        return $this->belongsTo(PharmacieClient::class, 'client_id');
    }

    /**
     * Relation to pharmacie
     * @return BelongsTo
     */
    public function pharmacie():BelongsTo{
        return $this->belongsTo(Pharmacie::class, 'pharmacie_id');
    }
}
