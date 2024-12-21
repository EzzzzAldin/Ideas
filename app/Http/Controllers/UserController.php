<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function show(User $user)
    {
        $ideas = $user->ideas()->paginate(5);

        return view("users.show", compact("user", "ideas"));
    }

    public function edit(User $user)
    {
        // Check User Edit Is Same Id User
        $this->authorize("update", $user);

        $editing = true;
        $ideas = $user->ideas()->paginate(5);
        return view("users.edit", compact("user", "editing", "ideas"));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Check User Edit Is Same Id User
        $this->authorize("update", $user);

        $validate = $request->validated();

        if ($request->has("image")) {

            // After validated Image we need store image in static file not temporary file
            $imagePath = $request->file("image")->store("profile", "public");

            $validate["image"] = $imagePath;

            Storage::disk("public")->delete($user->image ?? "");
        }

        $user->update($validate);

        return redirect()->route("profile");
    }

    public function profile()
    {
        // I Tell return Your method as call show and get id of user by auth methods
        return $this->show(auth()->user());
    }
}
