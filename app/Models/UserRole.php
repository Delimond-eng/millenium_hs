<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

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
        'role'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'role_create_At'
    ];

    /**
     * GET ALL USER BY ROLE
     * @return HasMany
    */

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;



    public function users() :HasMany{
        return $this->hasMany(User::class);
    }
}
