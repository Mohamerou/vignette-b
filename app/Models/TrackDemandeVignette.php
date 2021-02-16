<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackDemandeVignette extends Model
{
    use HasFactory;

    protected $fillable = [
    	'userId',
    	'enginId',
    	'administrationId',
    	'note',
    	'processed',
    	'rejected',
    ];
}
