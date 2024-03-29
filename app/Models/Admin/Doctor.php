<?php

namespace App\Models\Admin;

use App\Models\Guest\Message;
use App\Models\Guest\Review;
use App\Models\Guest\Vote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['doctor_img', 'doctor_cv', 'specializations'];

    // relazione 1-1 doctor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // collegamento specializations
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specialization');
    }

    // collegamento messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // collegamento reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // collegamento sponsorships
    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class)->withPivot('end_date');
    }

    // collegamento votes
    public function votes()
    {
        return $this->belongsToMany(Vote::class);
    }
}
