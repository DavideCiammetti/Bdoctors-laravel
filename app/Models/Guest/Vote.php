<?php

namespace App\Models\Guest;

use App\Models\Admin\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // collegamneto doctors
    public function doctors(){
        return $this->belongsToMany(Doctor::class);
    }
}
