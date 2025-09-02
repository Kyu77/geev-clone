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
        'view_count',
        'statut', // add this to fillable to avoid conflict with enum column

    ];

    public function user(){
        return $this->belongsTo(User::class);


    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function quality() {
        return $this->belongsTo(Quality::class);
    }
}
