<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // @desc show all listing
    public function index(Listing $listing)
    {

        $userId = Auth::id();

        return view("listings.index", [
            "listings" => Listing::latest()->filter(request(["tag", "search"]))->paginate(2),


        ]);
    }

    // @desc show single listing
    public function show(Listing $listing)
    {
        $userId = Auth::id();

        return view("listings.show", [
            "listing" => $listing,
            "isOwner" => $listing->user_id === $userId
        ]);
    }

    public function create()
    {
        return view("listings.create");
    }

    public function manage()
    {
        $userId = Auth::id();
        $userListings = DB::select('SELECT * FROM listings WHERE user_id = ?', [$userId]);

        return view("listings.manage", [
            "listings" => $userListings
        ]);
    }

    public function edit(Listing $listing, Request $request)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403, "Unauthorized");
            return;
        }

        return view("listings.edit", [
            "listing" => $listing
        ]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            "title" => "required",
            "tags" => "required",
            "company" => ["required", Rule::unique("listings", "company")],
            "location" => "required",
            "email" => ["required", "email", Rule::unique("listings", "email")],
            "website" => "required",
            "description" => "required",

        ]);

        if ($request->hasFile("logo")) {
            $formFileds["logo"] = $request->file("logo")->store("logos", "public");
        }

        $formFileds["user_id"] = Auth::id();

        Listing::create($formFileds);

        return redirect("/", 201)->with("success", "Successfully created");
    }

    public function update(Listing $listing, Request $request)
    {

        if ($listing->user_id !== Auth::id()) {
            abort(403, "Unauthorized");
            return;
        }

        $formFileds = $request->validate([
            "title" => "required",
            "tags" => "required",
            "company" => "required",
            "location" => "required",
            "email" => ["required", "email"],
            "website" => "required",
            "description" => "required",
        ]);

        if ($request->hasFile("logo")) {
            $formFileds["logo"] = $request->file("logo")->store("logos", "public");
        }

        $listing->update($formFileds);

        return back()->with("message", "Listing Update Successfully");
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403, "Unauthorized");
            return;
        }

        $listing->delete();

        return redirect("/")->with("message", "Listing Delete Successfully");
    }
}
