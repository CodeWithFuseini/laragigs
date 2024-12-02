<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    public function scopeFilter($query, array $filters)
    {
        if ($filters["tag"] ?? false) {
            $query->where("tags", "like", "%" . request("tag") . "%");
        }

        if ($filters["search"] ?? false) {
            $query->where("tags", "like", "%" . request("search") . "%")
                ->orWhere("description", "like", "%" . request("search") . "%")
                ->orWhere("tags", "like", "%" . request("search") . "%");
        }
    }


    public function user()
    {
        $this->belongsTo(User::class, "user_id");
    }
}
