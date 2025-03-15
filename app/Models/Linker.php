<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linker extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'icon'
    ];
}
