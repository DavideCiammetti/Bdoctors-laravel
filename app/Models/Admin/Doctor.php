<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // relazione 1-1 doctor
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
