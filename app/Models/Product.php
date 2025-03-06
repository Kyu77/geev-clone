<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'images',
        'user_id',
        'category_id',
        'quality_id',
        'statut_id',

    ];
}
