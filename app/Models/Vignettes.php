<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vignettes extends Model
{
    use HasFactory;

        protected $fillable = [
    	'userId',
    	'enginId',
    	'unique_token',
    	'qr',
    	'qr_download_path',
    	'expired_at',
    ];
}
