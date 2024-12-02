<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Listing;

// @desc GET / -> Get all listings
Route::get('/', [ListingController::class, "index"]);

// @desc GET / -> Show Create Route
Route::get("/listings/create", [ListingController::class, "create"])->middleware("auth");

// @desc POST /listings -> Store Data 
Route::post("/listing", [ListingController::class, "store"])->middleware("auth");

// @desc GET / -> Individue listings
Route::get("/listing/{listing}", [ListingController::class, "show"]);

Route::get("/listing/{listing}/edit", [ListingController::class, "edit"])->middleware("auth");


Route::get("/listings/manage", [ListingController::class, "manage"])->middleware("auth");


Route::put("/listings/{listing}", [ListingController::class, "update"])->middleware("auth");

Route::delete("/listings/{listing}", [ListingController::class, "destroy"])->middleware("auth");


// USERS ROUTES

Route::get("/user/register", [UserController::class, "registerView"]);
Route::get("/user/login", [UserController::class, "loginView"]);

Route::post("/user/register", [UserController::class, "registerUser"]);
Route::post("/user/login", [UserController::class, "loginUser"])->name("login")->middleware("guest");

Route::post("/user/logout", [UserController::class, "logoutUser"])->middleware("auth");
