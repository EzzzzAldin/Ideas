<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{

    public function store(CreateIdeaRequest $request)
    {

        // Validate Idea
        $validated = $request->validated();

        $validated["user_id"] = auth()->id();

        // Method Three To Create Record
        Idea::create($validated);

        // Redirect Home Page
        return redirect()->route("dashboard")->with("success", "Idea Created Successfully"); // with it is function created flash message
    }

    public function destroy(Idea $idea)
    {

        // Get Id
        // Delete Idea
        // Idea::where("id", $id)->firstOrFail()->delete();

        // Check If Owner Idea Only Can deleted
        $this->authorize("delete", $idea);

        // Method Of Route Model Binding
        $idea->delete();

        // Redirect Home Page
        return redirect()->route("dashboard")->with("success", "Idea Deleted Successfully"); // with it is function created flash message

    }

    public function show(Idea $idea)
    {

        return view("ideas.show", compact("idea"));
    }

    public function edit(Idea $idea)
    {

        // Check If Owner Idea Only Can edited
        $this->authorize("update", $idea);

        // If Enter Edit button Set New Var Is Editing True If Var Is True Show Form Edit
        $editing = true;

        return view("ideas.show", compact("idea", "editing"));
    }

    public function update(UpdateIdeaRequest $request, Idea $idea)
    {

        $this->authorize("update", $idea);

        // Validate Idea
        $validated = $request->validated();

        $idea->update($validated);

        return redirect()->route("ideas.show", $idea->id)->with("success", "Idea updated Successfully!");
    }
}
