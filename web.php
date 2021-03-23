<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\Modules\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Class to create "fake" (dynamic) routes
class Faker {
  
    // Call function 'Route::get' with param $path, and $filename type of callable
    private function add_routes($path, $filename) {
        call_user_func_array('Route::get', [$path, fn() => view($filename)]);
    }
    
    /*
    *   Retrive stored paths from database and add them from loop
    *   e.g. $array = DB::select ('select * from pages)';
    *   [0] => [
    *       'path' => '/home',
    *       'filename' => '/home.blade.php';
    *    ],
    *   [1] => [
    *       'path' => '/about',
    *       'filename' => '/about.blade.php';
    *    ]
    *     etc...
    */
    public function generate() {
        // Map of routes
        $map = App\Http\Controllers\RoutesMap::map_routes();
        // Default path for my views
        $default = App\Http\Controllers\RoutesMap::default_path();
        
        for($i = 0; $i <= count($map) - 1; $i++) {
            $path = $default.".".explode(".", $map[$i]['filename'])[0];
            $this->add_routes($map[$i]['path'], $path);
        }
    }
}
// New instance of Faker class
$fake_route = new Faker();
// Generate dynamic routes
$fake_route->generate();


/*    Your routes here    */
Route::get('/', function() {
  return "Hello, World!";
});
