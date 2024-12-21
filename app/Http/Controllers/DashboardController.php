<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {

        /*
        Method 1
        // Call Model
        $idea = new Idea();
        // Create Idea Functions
        $idea->content = "Test";
        $idea->likes = 0;
        // Created Idea
        $idea->save(); */

        // Method 2
        // Call Model & Add data
        // $idea = new Idea([
        //     "content" => "Test From Second Method",
        // ]);
        // // Created Idea
        // $idea->save();

        $ideas = Idea::orderBy("created_at", "DESC");

        // Check If Found Value On Search Bar
        if (request()->has("search")) {
            // Compare Value Of DB Between Value From Search Bar
            $ideas = $ideas->search(request("search", ""));
        }

        return view('dashboard', [
            "ideas" => $ideas->paginate(5)
        ]);
    }
}
