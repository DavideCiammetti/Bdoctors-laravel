<?php

namespace App\Models\Guest;

use App\Models\Admin\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    // collegamento doctors
    public function doctors()
    {
        return $this->belongsTo(Doctor::class);
    }
}
