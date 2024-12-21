<?php

namespace App\Http\Controllers;

use App\Models\Idea;

class IdeaLikeController extends Controller
{
    public function like(Idea $idea)
    {
        // Get Current User
        $liker = auth()->user();
        // To add & connect Relation Likes and Users
        $liker->likes()->attach($idea);

        return redirect()->route("dashboard")->with("success", "Liked Successfully!");
    }

    public function unlike(Idea $idea)
    {
        // Get Current User
        $liker = auth()->user();
        // To add & connect Relation Likes and Users
        $liker->likes()->detach($idea);

        return redirect()->route("dashboard")->with("success", "Liked Successfully!");
    }
}
