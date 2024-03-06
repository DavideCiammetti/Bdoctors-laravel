<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorVote extends Model
{
    use HasFactory;

    // Specifica il nome della tabella se non segue la convenzione di denominazione predefinita
    protected $table = 'doctor_vote';

    // Specifica che la chiave primaria è composta da due colonne
    protected $primaryKey = ['doctor_id', 'vote_id'];

    // Disabilita l'incremento automatico per la chiave primaria
    public $incrementing = false;

    // Specifica le colonne che possono essere riempite con il metodo create
    protected $fillable = [
        'doctor_id',
        'vote_id',
    ];
}
