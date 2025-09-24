<?php

// Simple test script to create a product with location data
require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    // Create a test product with location data
    $product = new App\Models\Product();
    $product->title = 'Test Product with Location';
    $product->description = 'This is a test product to verify map functionality';
    $product->user_id = 1; // Assuming user ID 1 exists
    $product->category_id = 1; // Assuming category ID 1 exists
    $product->quality_id = 1; // Assuming quality ID 1 exists
    $product->statut_id = 1; // Assuming statut ID 1 exists
    $product->latitude = 48.8566; // Paris coordinates
    $product->longitude = 2.3522;
    $product->images = 'test-image.jpg'; // You may need to adjust this
    $product->save();

    echo "Test product created successfully with ID: " . $product->id . "\n";
    echo "Location: " . $product->latitude . ", " . $product->longitude . "\n";
    echo "You can now test the map at: /product/" . $product->id . "\n";

} catch (Exception $e) {
    echo "Error creating test product: " . $e->getMessage() . "\n";
    echo "Make sure your database is properly set up and migrations are run.\n";
}
