<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientDetail extends Model
{
    use HasFactory;

    protected $fillable = ["patient_detail_poids","patient_detail_taille", "patient_detail_temperature", "patient_detail_age", "patient_id"];

    /**
     * Summary of patient
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo{
        return $this->belongsTo(Patients::class, "patient_id");
    }
}