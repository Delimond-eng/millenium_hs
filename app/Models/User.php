<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'agent_id',
        'user_role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'hopital_id',
        'hopital_emplacement_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'timestamp',
        'update_at'=>'timestamp',
        'create_at'=> 'timestamp',
    ];

    /**
     * Summary of agent
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agent():BelongsTo{
        return $this->belongsTo(Agents::class,foreignKey:'agent_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class,foreignKey:'user_role_id');
    }
}
