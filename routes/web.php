<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Listing;

// @desc GET / -> Get all listings
Route::get('/', [ListingController::class, "index"]);

// @desc GET / -> Show Create Route
Route::get("/listings/create", [ListingController::class, "create"]);

// @desc POST /listings -> Store Data 
Route::post("/listing", [ListingController::class, "store"]);

// @desc GET / -> Individue listings
Route::get("/listing/{listing}", [ListingController::class, "show"]);

Route::get("/listing/{listing}/edit", [ListingController::class, "edit"]);


Route::put("/listings/{listing}", [ListingController::class, "update"]);

Route::delete("/listings/{listing}", [ListingController::class, "destroy"]);


// USERS ROUTES

Route::get("/user/register", [UserController::class, "registerView"]);
Route::get("/user/login", [UserController::class, "loginView"]);


Route::post("/user/register", [UserController::class, "registerUser"]);
Route::post("/user/login", [UserController::class, "loginUser"]);

Route::post("/user/logout", [UserController::class, "logout"]);
