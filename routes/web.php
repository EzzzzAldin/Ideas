<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IdeaController as AdminIdeaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaLikeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get("lang/{lang}", function ($lang) {

    app()->setLocale($lang);

    // to store lang in session
    session()->put("locale", $lang);

    return redirect()->route("dashboard");
})->name("lang");

Route::get('/', [DashboardController::class, "index"])->name("dashboard");

// Another Method To Created Routes But Longer
// Route::group([
//     "prefix" => "ideas/",
//     "as" => "ideas.",
//     "middleware" => ["auth"],
// ], function () {

// Route::get("/{idea}", [IdeaController::class, "show"])->name("show")->withoutMiddleware(["auth"]);

// Route::post("", [IdeaController::class, "store"])->name("store")->withoutMiddleware(["auth"]);

// Route::get("/{idea}/edit", [IdeaController::class, "edit"])->name("edit");

// Route::put("/{idea}", [IdeaController::class, "update"])->name("update");

// Route::delete("/{idea}", [IdeaController::class, "destroy"])->name("destroy");

//     Route::post("/{idea}/comments", [CommentController::class, "store"])->name("comments.store");
// });

Route::resource("ideas", IdeaController::class)->except(["index", "create", "show"])->middleware("auth");

Route::resource("ideas", IdeaController::class)->only(["show"]);

Route::resource("ideas.comments", CommentController::class)->only(["store"])->middleware("auth");

Route::resource("users", UserController::class)->only("show");

Route::resource("users", UserController::class)->only("edit", "update")->middleware("auth");

Route::get("/profile", [UserController::class, "profile"])->middleware("auth")->name("profile");

Route::post("/users/{user}/follow", [FollowerController::class, "follow"])->middleware("auth")->name("users.follow");

Route::post("/users/{user}/unfollow", [FollowerController::class, "unfollow"])->middleware("auth")->name("users.unfollow");

Route::post("/ideas/{idea}/like", [IdeaLikeController::class, "like"])->middleware("auth")->name("ideas.like");

Route::post("/ideas/{idea}/unlike", [IdeaLikeController::class, "unlike"])->middleware("auth")->name("ideas.unlike");

Route::get("/feed", FeedController::class)->middleware("auth")->name("feed");

Route::get("/terms", function () {
    return view("terms");
})->name("terms");

Route::middleware(["auth", "can:admin"])->prefix("/admin")->as("admin.")->group(function () {

    Route::get("/", [AdminDashboardController::class, "index"])->name("dashboard");

    Route::resource("users", AdminUserController::class)->only("index");

    Route::resource("ideas", AdminIdeaController::class)->only("index");

    Route::resource("comments", AdminCommentController::class)->only("index", "destroy");
});
