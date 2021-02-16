<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeVignette extends Model
{
    use HasFactory;

        protected $fillable = [
    	'userId',
    	'enginId',
    	'administrationId',
    	'processed',
    	'rejected',
    ];
}
