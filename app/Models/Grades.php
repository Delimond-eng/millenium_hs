<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $grade_id
 * @property int    $grade_create_At
 * @property string $grade_libelle
 * @property string $grade_status
 */
class Grades extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grades';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'grade_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade_libelle', 'grade_create_At', 'grade_status'
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
        'grade_id' => 'int', 'grade_libelle' => 'string', 'grade_create_At' => 'timestamp', 'grade_status' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'grade_create_At'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
    public function agent(): BelongsTo{
        return $this->belongsTo(Agents::class, 'agent_grade_id', 'grade_id');
    }
}