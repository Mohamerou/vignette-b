<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engins extends Model
{
    use HasFactory;

    protected $fillable = [
    	'userId', 
    	'marque', 
    	'modele', 
    	'mairie', 
    	'chassie', 
    	'immatriculation', 
    	'puissanceFiscale', 
    	'signaler_perdue', 
    	'documentJustificatif', 
    	'tarif',
        'vignetteId',
        'signaler_perdue'
    ];
}