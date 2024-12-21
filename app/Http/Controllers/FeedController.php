<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Get User
        $user = auth()->user();

        // Get All Followings Id
        $followingIDs = $user->followings()->pluck("user_id");

        $ideas = Idea::whereIn("user_id", $followingIDs)->latest();

        // Check If Found Value On Search Bar
        if (request()->has("search")) {
            // Compare Value Of DB Between Value From Search Bar
            $ideas = $ideas->search(request("search", ""));
        }

        return view('dashboard', [
            "ideas" => $ideas->paginate(5),
        ]);
    }
}
