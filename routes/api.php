<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get("/listing/{listing}", function (Listing $listing) {
    return view("listings.show", [
        "listing" => $listing
    ]);
});
