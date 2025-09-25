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
        'statut',
        'latitude',
        'longitude',// add this to fillable to avoid conflict with enum column
        'location',
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

    /**
     * Get the location name for display purposes
     */
    public function getLocationAttribute()
    {
        // If location is already stored, return it
        if (!empty($this->attributes['location'])) {
            return $this->attributes['location'];
        }

        // If we have coordinates but no location name, try to get it from coordinates
        if ($this->latitude && $this->longitude) {
            // This is a simple fallback - in a real app you might want to cache this
            // or use a geocoding service to get the city name from coordinates
            return "Localisation: {$this->latitude}, {$this->longitude}";
        }

        return null;
    }

    /**
     * Scope to filter products within a certain radius from a given location
     * Note: Since SQLite doesn't support math functions, filtering is done in PHP
     */
    public function scopeNearLocation($query, $latitude, $longitude, $radiusKm)
    {
        if (!$latitude || !$longitude || !$radiusKm) {
            return $query;
        }

        return $query->whereNotNull('latitude')
                     ->whereNotNull('longitude');
    }

    /**
     * Calculate distance between two points using haversine formula
     */
    public function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
