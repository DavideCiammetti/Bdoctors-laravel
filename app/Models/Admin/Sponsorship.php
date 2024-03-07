<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    // collegamneto doctors
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
