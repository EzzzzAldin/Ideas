<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(CreateCommentRequest $request, Idea $idea)
    {
        // Old Method
        // $comment = new Comment();
        // $comment->idea_id = $idea->id;
        // $comment->user_id = auth()->id();
        // $comment->content = request()->get("content");
        // $comment->save();

        $validated = $request->validated();

        $validated["user_id"] = auth()->id();
        $validated["idea_id"] = $idea->id;

        Comment::create($validated);

        return redirect()->route("ideas.show", $idea->id)->with("success", "Comment Posted Successfully");
    }
}
