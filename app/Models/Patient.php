<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_card',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'phone',
        'address',
        'blood_group',
        'allergies',
    ];

    protected function casts(): array
    {
        return ['dob' => 'date'];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
