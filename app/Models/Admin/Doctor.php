<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = ['slug', 'doctor_img', 'doctor_cv', 'specializations'];

    // relazione 1-1 doctor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // collegamento specializations
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }
}
