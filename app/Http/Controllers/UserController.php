<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostCollection;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'posts' => new AllPostCollection($posts)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'user' => User::find($id),
            'posts' => new AllPostCollection($posts)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        $request->validate(['image' => 'required|mimes:jpg,jpeg,png']);
        $user = (new ImageService)->updateImage(auth()->user(), $request);
        $user->save();
    }
}
